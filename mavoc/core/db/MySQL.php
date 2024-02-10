<?php

namespace mavoc\core\db;

use PDO;

class MySQL {
    public static function createTable($table, $args) {
        $sql = '';

        $field_count = 0;
        $primary_key = '';

        $sql = '';
        // TODO: Be careful. Do not use with user passed in data. Need to prepare the table passed in.
        $sql .= 'CREATE TABLE `' . $table . '` ( ';
        foreach($args as $key => $arg) {
            if(is_string($arg)) {
                if($field_count) {
                    $sql .= ', ';
                }
                $sql .= self::createType($key, $arg);

                // Save the first $primary_key
                if($arg == 'id' && !$primary_key) {
                    $sql .= ' AUTO_INCREMENT ';
                    $primary_key = $key;
                }

                $field_count++;
            } elseif(is_array($arg) && isset($arg['type'])) {
                if($field_count) {
                    $sql .= ', ';
                }
                $sql .= self::createType($key, $arg['type'], $arg);

                // Save the first $primary_key
                if($arg == 'id' && !$primary_key) {
                    $sql .= ' AUTO_INCREMENT ';
                    $primary_key = $key;
                }

                $field_count++;
            }
        }

        if($primary_key) {
            $sql .= ', PRIMARY KEY (`' . $primary_key . '`)';
        }
        $sql .= ' )';

        return $sql;
    }

    public static function createType($key, $type = '', $extras = []) {
        $sql = '';

        if($type == 'id') {
            $sql .= '`' . $key . '` bigint unsigned NOT NULL ';
        } elseif($type == 'string') {
            $sql .= '`' . $key . '` varchar(255) ';
        } elseif($type == 'text') {
            $sql .= '`' . $key . '` longtext ';
        } elseif($type == 'boolean') {
            $sql .= '`' . $key . '` tinyint(1) NOT NULL ';
            if(isset($extras['default'])) {
                $sql .= "DEFAULT '" . $extras['default'] . " '";
            } else {
                $sql .= "DEFAULT '" . 0 . " '";
            }
        } elseif($type == 'datetime') {
            $sql .= '`' . $key . '` datetime ';
            if(isset($extras['default'])) {
                $sql .= "DEFAULT '" . $extras['default'] . " '";
            } else {
                $sql .= "DEFAULT NULL ";
            }
        } elseif($type == 'geometry') {
            $sql .= '`' . $key . '` geometry ';
        } elseif($type == 'integer') {
            $sql .= '`' . $key . '` int NOT NULL ';
            if(isset($extras['default'])) {
                $sql .= "DEFAULT '" . $extras['default'] . " '";
            } else {
                $sql .= "DEFAULT '" . 0 . " '";
            }
        }

        return $sql;
    }

    public function dropTable($table) {
        $sql = '';

        // TODO: Be careful. Do not use with user passed in data. Need to prepare the table passed in.
        $sql = 'DROP TABLE `' . $table . '`';

        return $sql;
    }

    public static function insert($table, $input) {
        $sql = 'INSERT INTO ' . $table . ' SET ';
        $args = [];
        foreach($input as $key => $value) {
            if(count($args) > 0) {
                $sql .= ',';
            }
            $sql .= '`' . $key . '`' . ' = ?';
            $args[] = $value;
        }

        return $sql;
    }

    public static function update($table, $input) {
        // Make sure to include created_at and updated_at
        $sql = 'UPDATE ' . $table . ' SET ';
        $args = [];
        foreach($input as $key => $value) {
            if(count($args) > 0) {
                $sql .= ',';
            }
            $sql .= '`' . $key . '`' . ' = ?';
            $args[] = $value;
        }
        $sql .= ' WHERE id = ?';

        return $sql;
    }

}
