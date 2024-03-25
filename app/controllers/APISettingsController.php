<?php

namespace app\controllers;

use app\models\Setting;

use app\services\APIService;

use DateTimeZone;

class APISettingsController {
    public function settings($req, $res) {
        $settings = Setting::get($req->user_id);

        $output = [];
        $output['timezone'] = $settings['timezone'];

        return APIService::success([], [], $output);
    }

    public function timezones($req, $res) {
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return APIService::success([], ['description' => 'This is a list of valid timezones.'], $timezones);
    }

    public function update($req, $res) {
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $data = $req->val('data', [
            'timezone' => ['required', ['in' => $timezones]],
        ]);

        Setting::set($req->user_id, $data);

        $settings = Setting::get($req->user_id);

        $output = [];
        $output['timezone'] = $settings['timezone'];

        return APIService::success([], [], $output);
    }
}
