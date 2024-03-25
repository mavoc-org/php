<?php

namespace app\controllers;

use app\models\User;

use app\services\APIService;

class APIMetricsController {
    public function users($req, $res) {
        $count = User::count();
        return APIService::success([], [], compact('count'));
    }
}
