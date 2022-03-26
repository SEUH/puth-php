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
}