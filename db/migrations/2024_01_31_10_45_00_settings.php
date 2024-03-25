<?php

// Up
$up = function($db) {
    $sql = $db->createTable('settings', [
        'id' => 'id',
        'user_id' => 'id',
        'name' => 'string',
        'key' => 'string',
        'value' => 'text',
        'editable' => ['type' => 'boolean', 'default' => 0],
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('settings');
    $db->query($sql);
};
