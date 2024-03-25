<?php

// Up
$up = function($db) {
    $sql = $db->createTable('password_resets', [
        'id' => 'id',
        'user_id' => 'id',
        'token' => 'string',
        'created_ip' => 'string',
        'used_ip' => 'string',
        'used' => ['type' => 'boolean', 'default' => 0],
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('password_resets');
    $db->query($sql);
};
