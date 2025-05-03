<?php

namespace mavoc\core;

// This is not chainable for future development reasons and to promote one way of doing things.
class Log {

    public function __construct() {
    }   

    public function init() {
    }

    public function write($file, $content = null) {
        if(is_string($content)) {
            $content = now() . "\t" . $content;
        } elseif(is_array($content)) {
            $content = implode("\t", $content);
            $content = now() . "\t" . $content;
        } else {
            $content = now();
        }

        $full_file = ao()->env('AO_STORAGE_DIR') . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $file;
        $full_file = ao()->hook('ao_log_full_file', $full_file, $file);

        if(!is_file($full_file)) {
            file_put_contents($full_file, $content);
        } else {
            file_put_contents($full_file, "\n" . $content, FILE_APPEND);
        }
    }


}
