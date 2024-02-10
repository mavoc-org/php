<?php

namespace app\controllers;

use app\models\Access;
use app\models\Follow;
use app\models\Collection;
use app\models\Number;
use app\models\Tracking;
use app\models\Username;

use app\services\ReservedService;

class UsernamesController {
    public function list($req, $res) {
        $list = Username::where('user_id', $req->user->data['id']);

        $res->view('usernames/list', compact('list'));
    }

    public function add($req, $res) {
        $res->view('usernames/add');
    }

    public function create($req, $res) {
        $val = $req->val($req->data, [
            'name' => ['required', ['match' => '/^[A-Za-z0-9_]+$/'], ['notIn' => [ReservedService::usernames()]], ['dbUnique' => 'usernames']],
        ]);


        $val['name'] = ao()->hook('app_username_create_username', $val['name']);
        $val['user_id'] = ao()->hook('app_username_create_user_id', $req->user_id);

        // If this is the first username created, mark it as the primary name.
        $usernames = Username::where('user_id', $req->user_id);
        if(count($usernames) == 0) {
            $val['primary'] = 1;
        }

        $username = Username::create($val);

        $res->success('Your username has been created.', '/post');
    }
}
