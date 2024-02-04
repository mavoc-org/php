<?php

// Up
$up = function($db) {
    /*
    $sql = <<<'SQL'
CREATE TABLE `settings` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,

    `user_id` bigint unsigned NOT NULL DEFAULT '0',
    `name` varchar(255) NOT NULL DEFAULT '',
    `content` longtext,
    `total_cents` int NOT NULL DEFAULT '0',
    `quantity_int2` int NOT NULL DEFAULT '0',
    `extra` longtext,
    `default` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
SQL;
*/

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
    /*
    $sql = <<<'SQL'
DROP TABLE `settings`;
SQL;
     */

    $sql = $db->dropTable('settings');
    $db->query($sql);
};
