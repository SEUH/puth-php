<?php

use Puth\PuthTestCase;
use Puth\Traits\PuthDuskInteractsWithCookies;
use Puth\ProductPage;


class PuthDuskInteractsWithCookiesTest extends PuthTestCase
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