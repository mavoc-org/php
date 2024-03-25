<?php

namespace app\controllers;

use app\models\DefaultColor;
use app\models\DefaultTag;
use app\models\Tag;
use app\models\Setting;

use DateTimeZone;

class SettingsController {
    public function settings($req, $res) {
        $title = 'Settings';
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        $settings = Setting::get($req->user_id);
        $res->fields = $settings;

        return compact('timezones', 'title');
    }

    public function update($req, $res) {
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $data = $req->val('data', [
            'timezone' => ['required', ['in' => $timezones]],
        ]);

        Setting::set($req->user_id, $data);

        $res->success('Settings updated successfully.', '/settings');
    }
}
