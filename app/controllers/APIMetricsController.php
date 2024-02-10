<?php

namespace app\controllers;

//use app\models\Example;

class APIMetricsController {
    public function examples($req, $res) {
        //$count = Example::count('status', 'published');
        $count = 0;
        return compact('count');
    }
}
