<?php

namespace app\controllers;

use app\models\APIKey;
use app\models\User;

use DateTime;

class ConsoleController {
    public function example($in, $out) {
        $out->write('This is an example.', 'green');
    }

    public function refresh($in, $out) {
        if(ao()->env('APP_HOST') == 'sandbox.example.com') {
            $confirm = 'y';
        } else {
            $confirm = $out->prompt('You are not currently on the sandbox server. Please confirm that you want to proceed. (y/n) (Default: n): ', ['y', 'n'], 'n');
        }
        if(in_array(strtolower($confirm), ['y', 'yes'])) {
            $dt = new DateTime();

            $out->write('Truncating tables', 'green');
            // Truncate the tables
            $tables = [];
            $tables[] = 'api_keys';
            $tables[] = 'password_resets';
            $tables[] = 'refresh_logins';
            $tables[] = 'settings';
            $tables[] = 'users';

            foreach($tables as $table) {
                $out->write('Truncate ' . $table, 'green');
                ao()->db->query(ao()->db->truncateTable($table));
            }

            // Create the users
            $out->write('Creating users', 'green');
            $names = [];
            $names[] = 'demo';
            $names[] = 'sandbox';
            $names[] = 'good';
            $names[] = 'bad';

            foreach($names as $name) {
                $out->write('Create ' . $name, 'green');
                $args = [];
                $args['name'] = ucfirst($name);
                $args['email'] = $name . '@example.com';
                $args['password'] = 'password';
                $user = User::create($args);
            }

            $out->write('Create API Keys', 'green');
            // Creat API Keys for demo
            $args = [];
            $args['user_id'] = 1;
            $args['name'] = 'Demo';
            $key = APIKey::create($args);

            // Manually set the API Key
            $args = [];
            $prefix = ao()->env('API_PREFIX');
            $suffix = ao()->env('API_SUFFIX');
            $token = '01234demo56789';
            $args['last4'] = substr($token, -4);
            $args['api_key'] = password_hash($prefix . $token . $suffix, PASSWORD_DEFAULT);
            $key->update($args);
        } else {
            $out->write('Did not confirm', 'red');
        }
        $out->write('Completed', 'green');
    }

    public function rsync($in, $out) {
        $error = '';
        $success = '';
        $servers = ao()->env('RSYNC_SERVERS');
        $sources = [];
        $destinations = [];

        if(isset($in->params[0]) && isset($in->params[1])) {
            $server = $in->params[0];
            if(isset($servers[$server])) {
                if(in_array($in->params[1], ['db'])) {
                    $dir = $in->params[1];
                    $sources[] = ao()->env('AO_DB_DIR') . '/';
                    $destinations[] = $servers[$server] . '/' . $dir . '/';
                } else {
                    $error = 'Please enter a valid directory like "db".';
                }
            } else {
                $error = 'The server entered is not valid.';
            }
        } elseif(isset($in->params[0])) {
            $server = $in->params[0];
            if(isset($servers[$server])) {
                $sources[] = ao()->env('AO_APP_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'app' . '/';
                $sources[] = ao()->env('AO_DB_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'db' . '/';
                $sources[] = ao()->env('AO_MAVOC_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'mavoc' . '/';
                $sources[] = ao()->env('AO_PLUGIN_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'plugins' . '/';
                $sources[] = ao()->env('AO_PUBLIC_DIR') . '/';
                $destinations[] = $servers[$server] . '/' . 'public' . '/';
            } else {
                $error = 'The server entered is not valid.';
            }
        } else {
            $error = 'Please include a server like "prod".';
        }

        if(count($sources)) {
            foreach($sources as $i => $source) {
                $destination = $destinations[$i];

                $out->write('rsync -avzh ' . $source . ' ' . $destination, 'green');
                $output = [];
                exec('rsync -avzh ' . $source . ' ' . $destination . ' 2>&1', $output, $exit_code);
                $out->write('exit_code: ' . $exit_code, 'green');
                $out->write(implode("\n", $output), 'green');
                $out->write('', 'green');
            }

            $success = 'The syncing is complete.';
        }

        if($error) {
            $out->write($error, 'red');
        }
        if($success) {
            $out->write($success, 'green');
        }
    }

    public function view($in, $out) {
        $out->view('console/view', ['color' => 'red']);
    }
}
