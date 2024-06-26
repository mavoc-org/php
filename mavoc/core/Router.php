<?php

namespace mavoc\core;

use mavoc\core\Exception;
use mavoc\core\Route;

class Router {
    public function __construct() {
        $dirs = ao()->hook('ao_router_plugin_dirs_start', []);
        foreach($dirs as $dir) {
            foreach(scandir($dir) as $file) {
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                $path = ao()->hook('ao_router_plugin_path', $path);
                if(is_file($path)) {
                    $parts = explode('/', $path);
                    $last = array_pop($parts);
                    $type = substr($last, 0, -4);
                    Route::$type = $type;
                    require_once $path;
                }
            }
        }


        $dir = ao()->env('AO_SETTINGS_DIR') . DIRECTORY_SEPARATOR . 'routes';
        $dir = ao()->hook('ao_router_app_dir', $dir);
        foreach(scandir($dir) as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            $path = ao()->hook('ao_router_app_path', $path);
            if(is_file($path)) {
                $parts = explode('/', $path);
                $last = array_pop($parts);
                $type = substr($last, 0, -4);
                Route::$type = $type;
                require_once $path;
            }
        }


        $dirs = ao()->hook('ao_router_plugin_dirs_end', []);
        foreach($dirs as $dir) {
            foreach(scandir($dir) as $file) {
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                $path = ao()->hook('ao_router_plugin_path', $path);
                if(is_file($path)) {
                    require_once $path;
                }
            }
        }
    }

    public function init() {
    }

    // Route is the preset value that tells how to parse.
    // Path is the actual URL with real data.
    public function parseParams($route, $path) {
        $output = [];

        $route_parts = explode('/', $route);
        $path_parts = explode('/', $path);

        foreach($route_parts as $i => $segment) {
            if(strpos($segment, '{') !== false) {
                $key = trim($segment, '{}');
                $output[$key] = $path_parts[$i];
            }
        }

        return $output;
    }

    public function route($req, $res) {
        if(ao()->hook('ao_router_route_enabled', true)) {
            $found = false;
            $req = ao()->hook('ao_router_route_req', $req);
            $res = ao()->hook('ao_router_route_res', $res);

            if($req->method == 'GET') {
                $routes = Route::$gets;
                if(isset(Route::$restrictions['GET'])) {
                    $restrictions = Route::$restrictions['GET'];
                } else {
                    $restrictions = [];
                }
            } elseif($req->method == 'PATCH') {
                $routes = Route::$patches;
            } elseif($req->method == 'POST') {
                $routes = Route::$posts;
                if(isset(Route::$restrictions['POST'])) {
                    $restrictions = Route::$restrictions['POST'];
                } else {
                    $restrictions = [];
                }
            } elseif($req->method == 'PUT') {
                $routes = Route::$puts;
            } elseif($req->method == 'DELETE') {
                $routes = Route::$deletes;
            }

            $routes = ao()->hook('ao_router_route_routes', $routes, $req, $res);
            $logged_in = ao()->session->user_id;

            foreach($routes as $route => $method) {
                // Make sure it matches whether or not the first slash was included in the route.
                //echo '$req->path: ' . $req->path;
                //echo '<br>';
                //echo '$route: ' . $route;
                //echo '<br>';
                //echo '<br>';

                $trimmed_route = trim($route, '/');
                $trimmed_path = trim($req->path, '/');

                $match = $trimmed_route == $trimmed_path;
                $match = ao()->hook('ao_router_route_match', $match, $req, $res, $route);

                // If it contains '{' then it is a dynamic route.
                if(!$match && strpos($route, '{') !== false) {
                    //echo preg_replace('|{[^}/]*}|', '[a-zA-Z0-9]*', $trimmed_route);die;
                    // This is a bit complicated. Turning the route into a regex then checking against the path.
                    $match = preg_match('|^' . preg_replace('|{[^}/]*}|', '[a-zA-Z0-9_.-]*', $trimmed_route) . '$|', $trimmed_path);
                    if($match) {
                        $req->params = $this->parseParams($trimmed_route, $trimmed_path);
                    }
                }

                if($match) {
                    $req->type = Route::$types[$route];
                    $res->type = Route::$types[$route];
                    if($req->session->type == 'api' && $req->type != $req->session->type) {
                        throw new Exception('Attempting to use an API key on a non-API endpoint is not allowed. Only API endpoints can be called with an API key.', '', 401, 'json');
                    }

                    // TODO: I don't like this current public/private set up but it works for now.
                    // Probably need to change it to be more array based so different levels of 
                    // private can be used ['admin', 'editor']
                    if($logged_in && isset($restrictions['public'][$route])) {
                        $res->redirect(ao()->env('APP_PRIVATE_HOME'));
                    }
                    if(!$logged_in && isset($restrictions['private'][$route])) {
                        if($req->type == 'api') {
                            $res->error('The requested endpoint requires a valid API key.');
                        } elseif($req->ajax) {
                            $res->error('The request requires you to be logged in. Please reload the page and login at the top right.');
                        } else {
                            $req->session->data['login_redirect'] = $req->uri;
                            $res->redirect(ao()->env('APP_PUBLIC_HOME'));
                        }
                    }
                    if($logged_in && isset($restrictions['private'][$route])) {
                        // This hook can be used to check if the user has the appropriate permission level.
                        $user_id = $logged_in;
                        ao()->hook('ao_router_logged_in_private', $user_id, $restrictions['private'][$route], $req, $res);
                    }

                    $method = ao()->hook('ao_router_route_method', $method, $req, $res, $route);

                    if(is_array($method) && count($method) == 2) {
                        $class_name = $method[0];
                        $class_name = ao()->hook('ao_router_route_class_name', $class_name);

                        if(strpos($class_name, '\\') === 0) {
                            $parts = explode('\\', $class_name);

                            $class = $class_name;
                            $class = ao()->hook('ao_router_route_class', $class);

                            $file_name = $parts[count($parts) - 1] .'.php';
                            $file_name = ao()->hook('ao_router_route_file_name', $file_name);
                        } else {
                            $parts = explode('\\', '\app\controllers\\');

                            $class = '\app\controllers\\' . $class_name;
                            $class = ao()->hook('ao_router_route_class', $class);

                            $file_name = $method[0] .'.php';
                            $file_name = ao()->hook('ao_router_route_file_name', $file_name);
                        }
                        $dir = implode('/', array_slice($parts, 1, -1));

                        $file = ao()->dir($dir) . DIRECTORY_SEPARATOR . $file_name;
                        $file = ao()->hook('ao_router_route_file', $file);

                        $method_name = $method[1];
                        $method_name = ao()->hook('ao_router_route_method_name', $method_name);

                        // Include controller file
                        if(is_file($file)) {
                            include_once $file;
                        }

                        // Instantiate the controller
                        if(ao()->hook('ao_router_route_controller_init', true)) {
                            $controller = new $class();
                            $controller = ao()->hook('ao_router_route_controller', $controller);
                        }

                        // Call the method on the controller
                        if(ao()->hook('ao_router_route_controller_call', true, $req, $res, $controller, $method_name)) {
                            if(is_callable([$controller, $method_name])) {
                                //$req->type = Route::$types[$route];
                                //$res->type = Route::$types[$route];
                                $vars = call_user_func([$controller, $method_name], $req, $res);
                                $found = true;

                                // Dynamically pick the view file.
                                if(is_object($vars) || is_array($vars)) {
                                    $view_dir = dashify(str_replace('Controller', '', $class_name));
                                    $view_found = $res->view($view_dir . '/' . dashify($method_name), $vars);
                                    if(!$view_found) {
                                        $res->json($vars);
                                    }
                                }
                            }
                        }

                        // Make sure it doesn't keep looping once found.
                        if(ao()->hook('ao_router_route_break', true)) {
                            break;
                        }
                    } elseif($method) {
                        // String passed in for method.
                        // Break into parts
                        $parts = explode('/', trim($req->path, '/'));

                        if(count($parts)) {
                            $class_name = $method;
                            $class_name = ao()->hook('ao_router_route_class_name_controller', $class_name);

                            $class = '\app\controllers\\' . $class_name;
                            $class = ao()->hook('ao_router_route_class_controller', $class);

                            $file_name = $method . '.php';
                            $file_name = ao()->hook('ao_router_route_file_name_controller', $file_name);

                            $file = ao()->dir('app/controllers') . DIRECTORY_SEPARATOR . $file_name;
                            $file = ao()->hook('ao_router_route_file_controller', $file);

                            $file_view = ao()->dir('app/views') . DIRECTORY_SEPARATOR . $file_name;
                            $file_view = ao()->hook('ao_router_route_file_view', $file_view);

                            // Include controller file
                            $use_generic = false;
                            if(is_file($file)) {
                                include_once $file;
                            } else {
                                $use_generic = true;
                            }

                            if($req->method == 'GET') {
                                $method_name = methodify($parts[0]);
                            } else {
                                $method_name = methodify($parts[0]) . classify($req->method);
                            }
                            if($use_generic) {
                                $class = '\mavoc\core\GenericController';
                                $method_name = 'view';
                                if(is_file($file_view)) {
                                    $view = dashify($method);
                                    $view = ao()->hook('ao_router_route_method_view_controller', $view);
                                } else {
                                    $view = dashify($parts[0]);
                                    $view = ao()->hook('ao_router_route_method_view_controller', $view);
                                }
                            }
                            $method_name = ao()->hook('ao_router_route_method_name_controller', $method_name);

                            // Instantiate the controller
                            if(ao()->hook('ao_router_route_controller_init_controller', true)) {
                                $controller = new $class();
                                $controller = ao()->hook('ao_router_route_controller_controller', $controller);
                            }

                            // Call the method on the controller
                            if(ao()->hook('ao_router_route_controller_call_controller', true)) {
                                if(is_callable([$controller, $method_name])) {
                                    //$req->type = Route::$types[$route];
                                    //$res->type = Route::$types[$route];
                                    if($use_generic) {
                                        $vars = call_user_func([$controller, $method_name], $req, $res, $view);
                                    } else {
                                        $vars = call_user_func([$controller, $method_name], $req, $res);
                                    }
                                    $found = true;

                                    // Dynamically pick the view file.
                                    if(is_object($vars) || is_array($vars)) {
                                        $view_dir = underscorify(str_replace('Controller', '', $class_name));
                                        $view_found = $res->view($view_dir . '/' . dashify($method_name), $vars);
                                        if(!$view_found) {
                                            $res->json($vars);
                                        }
                                    }
                                }
                            }

                        }
                        // Make sure it doesn't keep looping once found.
                        if(ao()->hook('ao_router_route_break', true)) {
                            break;
                        }
                    } else {
                        // No method passed in.
                        // First try to find the controller
                        $parts = explode('/', trim($req->path, '/'));

                        if(count($parts)) {
                            $class_name = classify($parts[0]) . 'Controller';
                            $class_name = ao()->hook('ao_router_route_class_name_missing', $class_name);

                            $class = '\app\controllers\\' . $class_name;
                            $class = ao()->hook('ao_router_route_class_missing', $class);

                            $file_name = classify($parts[0]) .'Controller.php';
                            $file_name = ao()->hook('ao_router_route_file_name_missing', $file_name);

                            $file = ao()->dir('app/controllers') . DIRECTORY_SEPARATOR . $file_name;
                            $file = ao()->hook('ao_router_route_file_missing', $file);

                            // Include controller file
                            $use_generic = false;
                            if(is_file($file)) {
                                include_once $file;
                            } else {
                                $use_generic = true;
                            }

                            if($req->method == 'GET') {
                                $method_name = methodify($parts[0]);

                                if($use_generic) {
                                    $class = '\mavoc\core\GenericController';
                                    $method_name = 'view';
                                    $view = dashify($parts[0]);
                                    $view = ao()->hook('ao_router_route_method_view_missing', $view);
                                }
                            }
                            $method_name = ao()->hook('ao_router_route_method_name_missing', $method_name);

                            // Instantiate the controller
                            if(ao()->hook('ao_router_route_controller_init_missing', true)) {
                                $controller = new $class();
                                $controller = ao()->hook('ao_router_route_controller_missing', $controller);
                            }

                            // Call the method on the controller
                            if(ao()->hook('ao_router_route_controller_call_missing', true)) {
                                if(is_callable([$controller, $method_name])) {
                                    //$req->type = Route::$types[$route];
                                    //$res->type = Route::$types[$route];
                                    if($use_generic) {
                                        $vars = call_user_func([$controller, $method_name], $req, $res, $view);
                                    } else {
                                        $vars = call_user_func([$controller, $method_name], $req, $res);
                                    }
                                    $found = true;

                                    // Dynamically pick the view file.
                                    if(is_object($vars) || is_array($vars)) {
                                        $view_dir = underscorify(str_replace('Controller', '', $class_name));
                                        $view_found = $res->view($view_dir . '/' . dashify($method_name), $vars);
                                        if(!$view_found) {
                                            $res->json($vars);
                                        }
                                    }
                                }
                            }

                        }
                        // Make sure it doesn't keep looping once found.
                        if(ao()->hook('ao_router_route_break', true)) {
                            break;
                        }
                    }
                }
            }

            if(!$found) {
                $res->status(404);
            }
        }
    }
}
