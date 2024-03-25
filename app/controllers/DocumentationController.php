<?php

namespace app\controllers;


class DocumentationController {
    public function introduction($req, $res) {
        return [];
    }

    public function authentication($req, $res) {
        return [];
    }

    public function download($req, $res) {
        $file = ao()->env('AO_STORAGE_DIR') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'demo' . DIRECTORY_SEPARATOR . 'd.png';
        header('Content-Type: image/png');
        header("Content-Transfer-Encoding: Binary"); 
        header('Content-disposition: attachment; filename="demo.png"'); 
        readfile($file); 
        exit;
    }

    public function request($req, $res) {
        return [];
    }

    public function response($req, $res) {
        return [];
    }

    public function sandbox($req, $res) {
        return [];
    }

    public function client($req, $res) {
        return [];
    }

    public function cli($req, $res) {
        return [];
    }

    public function changelog($req, $res) {
        return [];
    }

    public function endpoints($req, $res) {
        return [];
    }

    public function metrics($req, $res) {
        return [];
    }

    public function miscellaneous($req, $res) {
        return [];
    }

    public function settings($req, $res) {
        return [];
    }

    public function user($req, $res) {
        return [];
    }

}
