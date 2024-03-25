<?php

namespace app;

use app\models\Setting;
use app\models\User;

use mavoc\core\Exception;

use DateTime;
use DateTimeZone;

class App {
    public $debug;

    public function init() {
		// Run migrations if the user is not running a command line command and the db needs to be migrated.
		if(!defined('AO_CONSOLE_START') && ao()->env('DB_USE') && ao()->env('DB_INSTALL')) {
			ao()->once('ao_db_loaded', [$this, 'install']);
		} 

        ao()->filter('ao_response_partial_args', [$this, 'cacheDate']);
        ao()->filter('ao_response_partial_args', [$this, 'partials']);
        ao()->filter('ao_model_process_dates_timezone', [$this, 'processTimezone']);

        ao()->filter('helper_wordify_output', [$this, 'wordify']);
        ao()->filter('helper_split_input', [$this, 'splitInput']);

        ao()->filter('ao_router_logged_in_private', [$this, 'apiPremiumCheck']);
    }

    // Checks if the API access allows private access.
    public function apiPremiumCheck($user_id, $req, $res) {
        if($req->type == 'api') {
            $premium_level = Setting::get($user_id, 'premium_level');
            if($premium_level == 0) {
                throw new Exception('In order to access a private endpoint you need to have a premium account. Please upgrade to a premium account to access this endpoint.', '', 401, 'json');
            }
        }
        return $user_id;
    }

    public function cacheDate($vars, $view, $req, $res) {
        if($view == 'head' || $view == 'foot') {
            $vars['cache_date'] = '2024-03-24';
        }

        return $vars;
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
        }
        return $input;
    }

    // Uppercase the title
    public function wordify($input) {
        $output = str_replace('Appname', 'AppName', $input);
        return $output;
    }
}
