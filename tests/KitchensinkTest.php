<?php

use Puth\PuthTestCase;
use Puth\Traits\PuthDuskUrlAssertions;


class KitchensinkTest extends PuthTestCase
{
    use PuthDuskUrlAssertions;
    
    protected string $baseUrl = 'https://example.cypress.io/';
    
    public bool $dev = false;
    public bool $snapshot = false;
    
    public function testVisitDomain()
    {
        $navbar = $this->page->get('#navbar');
        $githubLink = $navbar->contains('GitHub')[0];
        
        $this->assertUrlIs($this->baseUrl);
        $this->context->assertStrictEqual($this->page->url(), $this->baseUrl);
        $this->page->assertUrlIs($this->baseUrl);
    }
    
    public function testWithin() {
        $this->page->get('#actions')->within(function ($banner) {
            echo "[p content] " . $banner->get('p')->getProperty('textContent')->jsonValue() . "\n";
        });
    }
    
    public function testJsonValue() {
        $this->page->get('.navbar')->getProperty('className')->jsonValue();
    }
}