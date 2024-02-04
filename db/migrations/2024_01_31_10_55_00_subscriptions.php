<?php

// Up
$up = function($db) {
    $sql = $db->createTable('subscriptions', [
        'id' => 'id',
        'user_id' => 'id',
        'base_plan' => 'string',
        'status' => 'string',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ]);

    $db->query($sql);
};

// Down
$down = function($db) {
    $sql = $db->dropTable('subscriptions');
    $db->query($sql);
};
