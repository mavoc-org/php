<?php

namespace app;

// This file (.example.Local.php) should be copied to .Local.php to work.
// Useful for temporary code additions. The .Local.php file is in the .gitignore file.
class Local {
    public function init() {
        if(ao()->env('APP_DEBUG')) {    
            //ao()->filter('ao_some_hook', [$this, 'debug']);
            //ao()->filter('ao_final_exception_redirect', [$this, 'finalException']);
        }

        ao()->filter('ao_response_partial_finish', [$this, 'partial']);
    }

    public function finalException($redirect, $e) {
        echo 'died before redirect';
        echo '<br>';
        dd($e);
    }

    public function debug($data) {
        // Add some debug code here.
        if(ao()->request->user_id == 2) {
        }

        // Changed the file
        return $data;
    }

    public function partial($output, $view, $args) {
        if($view == 'head') {
            $output .= "\n\n";
            $output .= '        <link href="/local/css/local.css?cache-date=' . _esc($args['cache_date']) . '" rel="stylesheet">';
            $output .= "\n\n";
        } elseif($view == 'view_app_before') {
            $output = '<div id="environment" class="notice error"><p>Currently viewing the dev server.</p></div>';
        } elseif($view == 'view_notice_before') {
            bufferStart();
        } elseif($view == 'view_notice_after') {
            bufferHide();
            $output = '<div class="notice"><p>This is a custom message.</p></div>';
        }
        return $output;
    }
}
