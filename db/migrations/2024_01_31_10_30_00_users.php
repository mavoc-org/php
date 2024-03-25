<?php

// Up
$up = function($db) {
    $sql = $db->createTable('users', [
        'id' => 'id',
        'name' => 'string',
        'email' => 'string',
        'username' => 'string',
        'password' => 'string',
        'data' => 'text',
        'encrypted' => ['type' => 'boolean', 'default' => 0],
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('users');
    $db->query($sql);
};

