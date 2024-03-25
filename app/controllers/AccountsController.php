<?php

namespace app\controllers;

class AccountsController {
    public function account($req, $res) {
        $res->fields['name'] = $req->user->data['name'];
        $res->fields['email'] = $req->user->all['email'];

        return [];
    }

    public function update($req, $res) {
        if(ao()->env('APP_LOGIN_TYPE') != 'db') {
            $res->error('There was a problem processing the requested action.');
        }
        $val = $req->val('data', [
            'name' => ['required'],
            'email' => ['required', 'email', ['dbUnique' => ['users', 'id', $req->user_id]]],
        ]);

        $req->user->update($val);

        $res->success('Account has been updated.');
    }
}
