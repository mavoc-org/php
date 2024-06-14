<?php

namespace app\controllers;

use app\models\Changelog;

class ChangelogsController {
	public function add($req, $res) {
		return [];
    }

    public function create($req, $res) {
        $data = $req->val('data', [
            'content' => ['required'],
        ]); 

        $args = [];
        $args['user_id'] = $req->user_id;
        $args['content'] = $data['content'];
        $item = Changelog::create($args);

        $res->success('Changelog created.', '/changelog');
    }

	public function edit($req, $res) {
        $item = Changelog::find($req->params['id']);

        $res->fields['content'] = $item->data['content'];
        return compact('item');
    }

    public function list($req, $res) {
        $title = 'Changelog';
        $page = clean($req->query['page'] ?? 1, 'int', 1);
        $per_page = 100; 

        $items = Changelog::all([$per_page, $page]);
        $pagination = Changelog::count([], [$per_page, $page, 'pagination', $req->path]);
        return compact('items', 'title', 'pagination');
    }

    public function update($req, $res) {
        $data = $req->val('data', [
            'content' => ['required'],
        ]); 

        $args = [];
        $args['user_id'] = $req->user_id;
        $args['content'] = $data['content'];
        $item = Changelog::updateWhere($args, 'id', $req->params['id']);

        $res->success('Changelog updated.', '/changelog');
    }

    public function view($req, $res) {
        $item = Changelog::find($req->params['id']);
        $title = 'Changelog - ' . $item->data['created_at']->format('l, M j, Y');
        return compact('item', 'title');
    }

    public function rss($req, $res) {
        $page = clean($req->query['page'] ?? 1, 'int', 1);
        $per_page = 100; 

        $items = Changelog::all([$per_page, $page]);
        $pagination = Changelog::count([], [$per_page, $page, 'pagination', $req->path]);
        return compact('items', 'pagination');
    }
}
