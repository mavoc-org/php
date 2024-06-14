<?php

namespace app;

use app\models\Setting;
use app\models\User;

use mavoc\core\Exception;

use DateTime;
use DateTimeZone;

class App {
    public $default_title = false;
    public $preset_title = false;
    public $debug;

    public function init() {
		// Run migrations if the user is not running a command line command and the db needs to be migrated.
		if(!defined('AO_CONSOLE_START') && ao()->env('DB_USE') && ao()->env('DB_INSTALL')) {
			ao()->once('ao_db_loaded', [$this, 'install']);
		} 

        ao()->filter('ao_response_view_args', [$this, 'cacheDate']);
        ao()->filter('ao_response_partial_args', [$this, 'cacheDate']);
        ao()->filter('ao_response_partial_args', [$this, 'partials']);
        ao()->filter('ao_model_process_dates_timezone', [$this, 'processTimezone']);


        ao()->filter('ao_response_default_title', [$this, 'defaultTitle']);
        ao()->filter('ao_response_preset_title', [$this, 'presetTitle']);
        ao()->filter('app_html_head_title', [$this, 'htmlTitle']);

        ao()->filter('helper_esc_format', [$this, 'dateTimeFormat']);
        ao()->filter('helper_wordify_output', [$this, 'wordify']);
        ao()->filter('helper_split_input', [$this, 'splitInput']);

        ao()->filter('ao_router_logged_in_private', [$this, 'premiumCheck']);
    }

    // Checks if the API access allows private access.
    public function premiumCheck($user_id, $groups, $req, $res) {
        if($req->type == 'api') {
            $premium_level = Setting::get($user_id, 'premium_level');
            if($premium_level == 0) {
                throw new Exception('In order to access a private endpoint you need to have a premium account. Please upgrade to a premium account to access this endpoint.', '', 401, 'json');
            }
        } elseif(count($groups)) {
            $found = false;
            if(!$found && in_array('admin', $groups) && in_array($user_id, ao()->env('APP_GROUP_ADMIN'))) {
                $found = true;
            }

            if(!$found && in_array('editor', $groups) && in_array($user_id, ao()->env('APP_GROUP_EDITOR'))) {
                $found = true;
            }

            if(!$found) {
                throw new Exception('The requested page or action is not available.');
            }
        }
        return $user_id;
    }

    public function cacheDate($vars, $view, $req, $res) {
        //if($view == 'head' || $view == 'foot') {
            //$vars['cache_date'] = '2024-03-24';
        //}
        $vars['cache_date'] = '2024-03-24';

        return $vars;
    }

    public function dateTimeFormat($format) {
        $format = 'm/d/y';
        return $format;
    }

    public function defaultTitle($title) {
        $this->preset_title = false;
        $this->default_title = true;
        return $title;
    }

    public function htmlTitle($title) {
        $add_suffix_to_title = true;
        if($this->preset_title) {
            $title .= ' - ' . ao()->env('APP_NAME');
        } elseif($this->default_title) {
            $title = ao()->env('APP_NAME');
        }

        return $title;
    }

    public function install() {
        try {
            $count = User::count();
        } catch(\Exception $e) {
            //ao()->command('work');
            ao()->command('mig init');
            ao()->command('mig up');

            // Redirect to home page now that the database is installed.
            header('Location: /');
            exit;
        }
    } 

    public function partials($vars, $view, $req, $res) {
        if($view == 'sidebar_account') {
            $vars['item_count'] = 3;
        }

        return $vars;
    }

    public function presetTitle($title) {
        $this->preset_title = true;
        $this->default_title = false;
        return $title;
    }

    public function processTimezone($timezone, $table) {
        // We don't want to end up in an infinite loop call Setting::get() over and over 
        if($table == 'settings') {
            return $timezone;
        }

        $timezone = Setting::get(ao()->request->user_id, 'timezone');
        return $timezone;
    }

    public function splitInput($input) {
        if(substr($input, 0, 3) == 'API') {
            $input = 'Api' . substr($input, 3);
        } elseif(substr($input, 0, 3) == 'RSS') {
            $input = 'Rss' . substr($input, 3);
        } elseif(substr($input, -3) == 'RSS') {
            $input = substr($input, 0, -3) . 'Rss';
        }
        return $input;
    }

    // Uppercase the title
    public function wordify($input) {
        $output = str_replace('Appname', 'AppName', $input);
        return $output;
    }
}
