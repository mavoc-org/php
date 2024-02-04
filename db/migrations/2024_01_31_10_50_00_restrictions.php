<?php

// Up
$up = function($db) {
    $sql = $db->createTable('restrictions', [
        'id' => 'id',
        'user_id' => 'id',
        'premium_level' => ['type' => 'integer', 'default' => 0],
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('restrictions');
    $db->query($sql);
};
