<?php

// Up
$up = function($db) {
    $sql = $db->createTable('api_keys', [
        'id' => 'id',
        'user_id' => 'id',
        'name' => 'string',
        'api_key_hash' => 'string',
        'prefix' => 'string',
        'suffix' => 'string',
        'last4' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('api_keys');
    $db->query($sql);
};
