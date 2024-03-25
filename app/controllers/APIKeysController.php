<?php

namespace app\controllers;

use app\models\APIKey;
use app\models\Username;

class APIKeysController {

	public function add($req, $res) {
		return [];
    }

    public function copy($req, $res) {
        return [];
    }

    public function create($req, $res) {
        $data = $req->val('data', [
            'name' => ['required', ['dbUnique' => ['api_keys', '', '', 'user_id', $req->user_id]]],
        ]); 

        $args = [];
        $args['user_id'] = $req->user_id;
        $args['name'] = $data['name'];
        $item = APIKey::create($args);

        $res->view('api-keys/copy', compact('item'));
    }

    public function list($req, $res) {
        $keys = APIKey::where('user_id', $req->user_id);
        return compact('keys');
    }

    public function delete($req, $res) {
        $params = $req->val('params', [
            'id' => ['required', ['dbOwner' => ['api_keys', 'id', $req->user_id]]],
        ]); 

        APIKey::delete($params['id']);

        $res->success('Item successfully deleted.');
    }







/*
    public function copy($req, $res) {
        return [];
    }
*/


}
