<?php

namespace app;

use app\models\Setting;
use app\models\User;

use DateTime;
use DateTimeZone;

class App {
    public $debug = false;
    public function init() {
		// Run migrations if the user is not running a command line command and the db needs to be migrated.
		if(!defined('AO_CONSOLE_START') && ao()->env('DB_USE') && ao()->env('DB_INSTALL')) {
			ao()->once('ao_db_loaded', [$this, 'install']);
		} 

        ao()->filter('ao_response_partial_args', [$this, 'cacheDate']);
        ao()->filter('ao_model_process_dates_timezone', [$this, 'processTimezone']);

        if($this->debug) {
            ao()->filter('ao_final_exception_redirect', [$this, 'finalException']);
        }
    }

    public function cacheDate($vars, $view, $req, $res) {
        if($view == 'head' || $view == 'foot') {
            $vars['cache_date'] = '2022-07-15';
        }

        return $vars;
    }

    public function finalException($redirect, $e) {
        echo 'died before redirect';
        dd($e);
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

    public function processTimezone($timezone, $table) {
        // We don't want to end up in an infinite loop call Setting::get() over and over 
        if($table == 'settings') {
            return $timezone;
        }

        $timezone = Setting::get(ao()->request->user_id, 'timezone');
        return $timezone;
    }
}
