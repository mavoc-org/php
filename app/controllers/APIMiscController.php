<?php

namespace app\controllers;

use app\services\APIService;

use DateTime;

class APIMiscController {
    public function hello($req, $res) {
        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = ['name' => 'World'];
        return $output;
    }

    public function helloSubmit($req, $res) {
        $data = $req->val($req->data, [
            'name' => ['required'],
        ]);

        $output = [];
        $output['status'] = 'success';
        $output['messages'] = [];
        $output['meta'] = new \stdClass();
        $output['data'] = ['name' => $data['name']];
        return $output;
    }
}
