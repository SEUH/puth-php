<?php

namespace Tests\Feature;

use Puth\Traits\PuthDuskInteractsWithCookies;
use Tests\TestCase;

class PuthDuskInteractsWithCookiesTest extends TestCase
{
    use PuthDuskInteractsWithCookies;
    
    protected string $baseUrl = 'https://playground.puth.dev/';
    
    // function testAddCookie()
    // {
    //     $page = new ProductPage();
    //
    //     // TODO write test
    // }
    
}