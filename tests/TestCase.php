<?php

namespace Tests;

use Puth\PuthTestCase;

class TestCase extends PuthTestCase {

    public function getPuthInstanceUrl(): string
    {
        if (!empty($instanceUrl = getenv('PUTH_REMOTE_URL'))) {
            return $instanceUrl;
        }

        return parent::getPuthInstanceUrl();
    }

    public function shouldCreatePuthProcess()
    {
        return getenv('PUTH_REMOTE_URL') !== false;
    }

//    public function puthCollectFilesOnFailure()
//    {
//        $additions = [
//            dirname(__FILE__) . '/../composer.json',
//            dirname(__FILE__) . '/../laravel.log',
//        ];
//
//        return array_map(function ($file) {
//            $file = realpath($file);
//            return [
//                'path' => $file,
//                'content' => file_get_contents($file),
//            ];
//        }, $additions);
//    }
}