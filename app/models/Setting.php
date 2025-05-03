<?php

namespace app\models;

use mavoc\core\Model;


class Setting extends Model {
    public static $table = 'settings';
    public static $order = ['name' => 'asc'];
    public static $columns = null;

    public static $defaults = [
        'timezone' => [
            'name' => 'Timezone',
            'key' => 'timezone',
            'value' => 'UTC',
            'editable' => 1,
        ],
        'week_start' => [
            'name' => 'Start Of Week',
            'key' => 'week_start',
            'value' => 'Sunday',
            'editable' => 1,
        ],
        'expires_at' => [
            'name' => 'Expires At',
            'key' => 'expires_at',
            'value' => '2038-01-01 10:00:00',
            'editable' => 0,
        ],
        'plan' => [
            'name' => 'Plan',
            'key' => 'plan',
            'value' => 'default',
            'editable' => 0,
        ],
        'premium_level' => [
            'name' => 'Premium Level',
            'key' => 'premium_level',
            'value' => 100,
            'editable' => 0,
        ],
        'status' => [
            'name' => 'Status',
            'key' => 'status',
            'value' => 'active',
            'editable' => 0,
        ],
    ];

    public static function get($user_id = 0, $key = null) {
        $output = null;

        if(is_array($key)) {
            $results = Setting::where('user_id', $user_id, 'data');
            $settings = [];
            foreach($results as $item) {
                if(in_array($item['key'], $key)) {
                    $settings[$item['key']] = $item['value'];
                }
            }

            // Set defaults
            foreach(self::$defaults as $default) {
                if(in_array($default['key'], $key) && !isset($settings[$default['key']])) {
                    $settings[$default['key']] = $default['value'];
                }
            }

            $output = $settings;
        } elseif($key) {
            $result = Setting::by(['user_id' => $user_id, 'key' => $key], '', 'data');

            if($result) {
                $output = $result['value'];
            } elseif(isset(self::$defaults[$key])) {
                $output = self::$defaults[$key]['value'];
            }
        } else {
            $results = Setting::where('user_id', $user_id, 'data');
            $settings = [];
            foreach($results as $item) {
                $settings[$item['key']] = $item['value'];
            }

            // Set defaults
            foreach(self::$defaults as $default) {
                if(!isset($settings[$default['key']])) {
                    $settings[$default['key']] = $default['value'];
                }
            }

            $output = $settings;
        }

        return $output;
    }

    public static function set($user_id = 0, $key = null, $value = null) {
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $item = Setting::by(['user_id' => $user_id, 'key' => $k]);
                if($item) {
                    $item->data['value'] = $v;
                    $item->save();
                } elseif(isset(self::$defaults[$k]['name']) && isset(self::$defaults[$k]['editable'])) {
                    $item = Setting::create([
                        'user_id' => $user_id, 
                        'name' => self::$defaults[$k]['name'], 
                        'editable' => self::$defaults[$k]['editable'], 
                        'key' => $k, 
                        'value' => $v,
                    ]);
                } else {
                    $item = Setting::create([
                        'user_id' => $user_id, 
                        'name' => $k, 
                        'editable' => 0, 
                        'key' => $k, 
                        'value' => $v,
                    ]);
                }
            }
        } else {
            $item = Setting::by(['user_id' => $user_id, 'key' => $key]);
            if($item) {
                $item->data['value'] = $value;
                $item->save();
            } elseif(isset(self::$defaults[$key]['name']) && isset(self::$defaults[$key]['editable'])) {
                $item = Setting::create([
                    'user_id' => $user_id, 
                    'name' => self::$defaults[$key]['name'], 
                    'editable' => self::$defaults[$key]['editable'], 
                    'key' => $key, 
                    'value' => $value,
                ]);
            } else {
                $item = Setting::create([
                    'user_id' => $user_id, 
                    'name' => $key, 
                    'editable' => 0, 
                    'key' => $key, 
                    'value' => $value,
                ]);
            }
        }
    }

    public static function unset($user_id = 0, $key = null) {
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $item = Setting::by(['user_id' => $user_id, 'key' => $k]);
                if($item) {
                    Setting::delete($item->id);
                }
            }
        } else {
            $item = Setting::by(['user_id' => $user_id, 'key' => $key]);
            if($item) {
                Setting::delete($item->id);
            }
        }
    }
}
