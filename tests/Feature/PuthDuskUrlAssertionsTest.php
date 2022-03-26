<?php

namespace Tests\Feature;

use Puth\Traits\PuthDuskUrlAssertions;
use Tests\TestCase;

class PuthDuskUrlAssertionsTest extends TestCase
{
    use PuthDuskUrlAssertions;
    
    protected string $baseUrl = 'https://playground.puth.dev/?test=puth#fragment-puth';
    
    public function testAssertUrlIs()
    {
        $this->assertUrlIs('https://playground.puth.dev/');
    }
    
    public function testAssertSchemeIs()
    {
        $this->assertSchemeIs('https');
    }
    
    public function testAssertSchemeIsNot()
    {
        $this->assertSchemeIsNot('http');
    }
    
    public function testAssertHostIs()
    {
        $this->assertHostIs('playground.puth.dev');
    }
    
    public function testAssertHostIsNot()
    {
        $this->assertHostIsNot('not.the.host');
    }
    
    public function testAssertPortIs() {
        $this->assertPortIs(443);
    }
    
    public function testAssertPortIsNot() {
        $this->assertPortIsNot(12345);
    }
    
    public function testAssertPathIs()
    {
        $this->page->goto('https://example.cypress.io/commands/querying');
        $this->assertPathIs('/commands/querying');
    }
    
    public function testAssertPathBeginsWith()
    {
        $this->page->goto('https://example.cypress.io/commands/querying');
        $this->assertPathBeginsWith('/commands');
    }
    
    public function testAssertPathIsNot()
    {
        $this->page->goto('https://example.cypress.io/commands/querying');
        $this->assertPathIsNot('querying');
    }

    public function testAssertFragmentIs()
    {
        $this->assertFragmentIs('fragment-puth');
    }
    
    public function testAssertFragmentBeginsWith()
    {
        $this->assertFragmentBeginsWith('fragment');
    }
    
    public function testAssertFragmentIsNot()
    {
        $this->assertFragmentIsNot('fragment-not');
    }
    
    // public function testAssertRouteIs()
    // {
    //     // TODO $this->assertRouteIs();
    // }

    public function testAssertQueryStringHas()
    {
        $this->assertQueryStringHas('test', 'puth');
    }
    
    public function testAssertQueryStringMissing()
    {
        $this->assertQueryStringMissing('test-missing');
    }
    
    public function testAssertHasQueryStringParameter()
    {
        $this->assertHasQueryStringParameter('test');
    }
}