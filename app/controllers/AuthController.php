<?php

namespace app\controllers;

use app\models\User;

class AuthController {
    public function account($req, $res) {
        $res->fields['name'] = $req->user->data['name'];
        $res->fields['email'] = $req->user->data['email'];

        return ['title' => 'Account'];
    }

    public function accountPost($req, $res) {
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

    public function login($req, $res) {
        return ['title' => 'Login'];
    }

    public function loginPost($req, $res) {
        $val = $req->val('data', [
            'login_email' => ['required', 'email'],
            'login_password' => ['required', 'password'],
        ]);

        $args = [];
        $args['email'] = $val['login_email'];
        $args['password'] = $val['login_password'];

        if(!User::login($args['email'], $args['password'])) {
            $res->error('The email and/or password did not match a user in the system.');
        }

        $res->redirect('/account');
    }

    public function logout($req, $res) {
        // TODO: Probably need to make checking for the referrer much easier 
        // (or automatic without having to call validate).
        $val = $req->val();

        $user = ao()->session->user;
        if($user) {
            $user->logout();
        } else {
            // If it gets in a weird place where logged in without an associated user, just destroy the session.
            ao()->session->logout();
        }
        
        $res->redirect('/');
    }

    public function registerPost($req, $res) {
        $val = $req->val('data', [
            'name' => ['required'],
            'email' => ['required', 'email', ['dbUnique' => 'users']],
            'password' => ['required', 'password'],
        ]);

        $user = User::create($val);
        $user->session();

        $res->redirect('/account');
    }
}
