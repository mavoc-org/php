<?php

namespace mavoc\core;

use mavoc\core\Modify;
use mavoc\core\Validate;

class Request {
    public $data = [];
    public $method = '';
    public $query = [];
    public $last_url = '/'; 
    public $param = [];
    public $params = [];
    public $path = '';
    // The header is misspelled so include both versions so you never have to remember which spelling to use.
    // https://en.wikipedia.org/wiki/HTTP_referer
    public $referrer = '';
    public $referer = ''; 

    public $res; 
    public $session; 
    public $clean; 
    public $validate; 
    public $user; 
    public $user_id; 

    public function __construct() {
    }   

    public function init() {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? '';

        if(isset($_SERVER['REQUEST_URI'])) {
            $this->path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        } else {
            $this->path = '';
        }

        if(isset($_SERVER['HTTP_REFERER'])) {
            $this->referrer = strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST));
            // TODO: If referrer is not set, need to add code to save the current url as the "last_url" and then use that here.
            $this->last_url = $_SERVER['HTTP_REFERER'];

        } else {
            $this->referrer = '';
        }
        $this->referer = $this->referrer;

        $this->data = $_POST;
        $this->query = $_GET;
    }

    public function clean($input = '', $list = []) {
        $fields = [];
        if(is_string($input)) {
            if($input == 'data') {
                $fields = $this->data;
            } elseif($input == 'params') {
                $fields = $this->params;
            }
        } else {
            $fields = $input;
        }
        $this->clean = new Clean($fields, $list, $this, $this->res);
        return $this->clean->fields;
    }

    public function val($input = '', $rules = [], $redirect = null) {
        $fields = [];
        if(is_string($input)) {
            if($input == 'data') {
                $fields = $this->data;
            } elseif($input == 'params') {
                $fields = $this->params;

                // We don't need referrer checking when validating params
                if(!isset($rules['_settings'])) {
                    $rules['_settings'] = ['check_referrer' => false];
                }
            } elseif($input == 'query') {
                $fields = $this->query;

                // We don't need referrer checking when validating params
                if(!isset($rules['_settings'])) {
                    $rules['_settings'] = ['check_referrer' => false];
                }
            }
        } else {
            $fields = $input;
        }
        $this->validate = new Validate($fields, $rules, $this, $this->res, $redirect);
        return $this->validate->fields;
    }
} 
