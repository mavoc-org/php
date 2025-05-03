<?php

// Up
$up = function($db) {
    $sql = $db->createTable('usernames', [
        'id' => 'id',
        'user_id' => 'id',
        'name' => 'string',
        'primary' => ['type' => 'boolean', 'default' => 0],
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);
    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('usernames');
    $db->query($sql);
};
