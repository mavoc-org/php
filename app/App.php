<?php

namespace app;

use app\models\User;

class App {
    public function init() {
		// Run migrations if the user is not running a command line command and the db needs to be migrated.
		if(!defined('AO_CONSOLE_START') && ao()->env('DB_USE') && ao()->env('DB_INSTALL')) {
			ao()->once('ao_db_loaded', [$this, 'install']);
		} 

        ao()->filter('ao_response_partial_args', [$this, 'cacheDate']);
    }

    public function cacheDate($vars, $view) {
        if($view == 'head' || $view == 'foot') {
            $vars['cache_date'] = '2022-07-15';
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
}
