<?php

namespace app;

// This file (.example.Debug.php) should be copied to .Debug.php to work. You will also need to set the
// environment variable APP_DEBUG to true.
// Useful for temporary code additions. The .Debug.php file is in the .gitignore file.
class Debug {
    public function init() {
        //ao()->filter('ao_some_hook', [$this, 'debug']);

        ao()->filter('ao_final_exception_redirect', [$this, 'finalException']);
    }

    public function finalException($redirect, $e) {
        echo 'Debug: died before redirect';
        echo '<br>';
        dd($e);
    }

    public function debug($data) {
        // Add some debug code here.

        // Changed the file
        return $data;
    }
}
