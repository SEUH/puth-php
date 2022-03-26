<?php

namespace Tests\Feature;

use Tests\TestCase;

class PuthQueryingTest extends TestCase
{
    protected string $baseUrl = 'https://playground.puth.dev/';
    
    function testGet()
    {
        $this->assertEquals('querying-get', $this->page->get('#querying-get')->getProperty('id')->jsonValue());
    }
    
    function testGetAll()
    {
        $this->assertCount(2, $this->page->getAll('.querying-get'));
    }
    
    function testContains()
    {
        $this->assertCount(2, $this->page->get('#querying-contains')->contains('apple'));
    }
}