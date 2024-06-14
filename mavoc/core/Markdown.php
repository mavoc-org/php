<?php

namespace mavoc\core;

// This is just a hacked together way to parse very limited markdown.
class Markdown {
    public static $bullet_opened = false;

    public static function operatorsExist($input) {
        if(preg_match('/(.*?)(^\*\s.*?$)(.*)/ms', $input, $matches)) {
            return ['bullet', $matches];
        }

        return false;
    }

    public static function operate($type, $matches) {
        $output = '';
        $output .= $matches[1];

        $content = $matches[2];
        if($type == 'bullet') {
            if(!self::$bullet_opened) {
                $output .= '<ul>';
                $output .= "\n";
                self::$bullet_opened = true;
            }
            $output .= '<li>';
            $output .= trim(preg_replace('/^\*\s/', '', $content));
            $output .= '</li>';

            if(!preg_match('/^\s\*\s.*[\r\n|\n|\r]?/m', $matches[3])) {
                $output .= "\n";
                $output .= '</ul>';
                $output .= "\n";
                self::$bullet_opened = false;
            }
        }

        $output .= $matches[3];

        return $output;
    }

    public static function parse($input) {
        $output = $input;

        $breaker = 0;
        while($response = self::operatorsExist($output)) {
            if($response[0] == 'bullet') {
                $output = self::operate('bullet', $response[1]);
            }

            // Make sure it doesn't loop forever
            $breaker++;
            if($breaker > 1000) {
                break;
            }
        }

        return $output;
    }
}
