<?php

namespace app\services;

class APIService {
    public static function success($messages = [], $meta = [], $data = []) {
        $output = [];
        $output['status'] = 'success';
        $output['messages'] = $messages;
        if(is_array($meta) && count($meta) == 0) {
            $output['meta'] = new \stdClass();
        } else {
            $output['meta'] = $meta;
        }
        if(is_array($data) && count($data) == 0) {
            $output['data'] = new \stdClass();
        } else {
            $output['data'] = $data;
        }

        return $output;
    }
}
