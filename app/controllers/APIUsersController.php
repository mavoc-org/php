<?php

namespace app\controllers;

use app\models\User;

use app\services\APIService;

use DateTimeZone;

class APIUsersController {
    public function read($req, $res) {
        $user = User::find($req->user_id);
        $settings = Setting::get($req->user_id);

        $output = [];
        $output['id'] = $user->data['user_id'];
        $output['name'] = $user->data['name'];
        $output['username'] = $user->data['username'];
        $output['timezone'] = $settings['timezone'];

        return APIService::success([], [], $output);
    }

    public function update($req, $res) {
        if(ao()->env('APP_LOGIN_TYPE') == 'db') {
            $data = $req->val('data', [
                'email' => ['optional', 'email', ['dbUnique' => ['users', 'id', $req->user_id]]],
                'name' => ['optional'],
                'username' => ['optional'],
            ]);

            $args = [];
            if(isset($data['email'])) {
                $args['email'] = $data['email'];
            }
            if(isset($data['name'])) {
                $args['name'] = $data['name'];
            }
            if(isset($data['username'])) {
                $args['username'] = $data['username'];
            }
            if(count($args)) {
                $req->user->update($args);
            }
        } else {
            $data = $req->val('data', [
                'name' => ['optional'],
                'username' => ['optional'],
            ]);

            $args = [];
            if(isset($data['name'])) {
                $args['name'] = $data['name'];
            }
            if(isset($data['username'])) {
                $args['username'] = $data['username'];
            }
            if(count($args)) {
                $req->user->update($args);
            }
        }

        $user = User::find($req->user_id);
        $settings = Setting::get($req->user_id);

        $output = [];
        $output['id'] = $user->data['user_id'];
        $output['name'] = $user->data['name'];
        $output['username'] = $user->data['username'];
        $output['timezone'] = $settings['timezone'];

        return APIService::success([], [], $output);
    }

}
