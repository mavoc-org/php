<?php

if(!function_exists('ao')) {
    function ao() {
        global $ao;
        return $ao;
    }
}

if(!function_exists('classify')) {
    function classify($input) {
        $words = preg_replace('/[\s,-_]+/', ' ', strtolower($input));
        $words = ucwords($words);
        $output = str_replace(' ', '', $words);
        return $output;
    }
}

if(!function_exists('dashify')) {
    function dashify($input) {
        $words = preg_replace('/[\s,-_]+/', ' ', strtolower($input));
        $parts = explode(' ', $words);
        if(count($parts)) {
            $parts[0] = strtolower($parts[0]);
        }
        $output = implode('-', $parts);
        return $output;
    }
}

if(!function_exists('_esc')) {
    function _esc($value, $double_encode = true) {   
        //return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8', $double_encode);
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8', $double_encode);
    }   
} 

if(!function_exists('esc')) {
    function esc($value, $double_encode = true) {   
        echo _esc($value, $double_encode);
    }   
} 

if(!function_exists('methodify')) {
    function methodify($input) {
        $words = preg_replace('/[\s,-_]+/', ' ', strtolower($input));
        $words = ucwords($words);
        $parts = explode(' ', $words);
        if(count($parts)) {
            $parts[0] = strtolower($parts[0]);
        }
        $output = implode('', $parts);
        return $output;
    }
}

if(!function_exists('now')) {
    function now() {
        $dt = new \DateTime();
        return $dt->format('Y-m-d H:i:s');
    }
}

if(!function_exists('_out')) {
    function _out($input, $color = null) {   
        $output = $input;

        // I prefer "if" over "switch".
        if($color == 'green') {
            $output = "\033[32m" . $output;
        } elseif($color == 'red') {
            $output = "\033[31m" . $output;
        }

        if($color) {
            $output .= "\033[0m";
        }

        $output .= "\n";

        return $output;
    }   
} 

if(!function_exists('out')) {
    function out($input, $color = null) {   
        echo _out($input, $color);
    }   
} 

if(!function_exists('pluralize')) {
    function pluralize($count = 0, $singular) {   
        // Very hacky approach. Eventually need to switch to something like this:
        // http://kuwamoto.org/2007/12/17/improved-pluralizing-in-php-actionscript-and-ror/
        if($count != 1) {
            return $count . ' ' . $singular . 's';
        } else {
            return $count . ' ' . $singular;
        }
    }   
} 

if(!function_exists('underscorify')) {
    function underscorify($input) {
        $words = preg_replace('/[\s,_-]+/', ' ', strtolower($input));
        $parts = explode(' ', $words);
        if(count($parts)) {
            $parts[0] = strtolower($parts[0]);
        }
        $output = implode('_', $parts);
        return $output;
    }
}

if(!function_exists('upperfy')) {
    function upperfy($input) {
        $output = preg_replace('/[\s,_-]+/', '_', strtoupper($input));
        return $output;
    }   
}

if(!function_exists('_uri')) {
    function _uri($input) {
        $output = '';
        $output .= ao()->env('APP_SITE');
        $output .= '/';
        $output .= trim($input, '/');
        return $output;
    }
}
if(!function_exists('uri')) {
    function uri($input) {
        echo _uri($input);
    }
}


if(!function_exists('wordify')) {
    function wordify($input) {
        $words = preg_replace('/[\s,-_]+/', ' ', strtolower($input));
        $words = ucwords($words);
        $output = $words;
        return $output;
    }
}
