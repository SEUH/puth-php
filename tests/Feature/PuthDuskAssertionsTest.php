<?php

use Puth\PuthTestCase;
use Puth\Traits\PuthDuskAssertions;


class PuthDuskAssertionsTest extends PuthTestCase
{
    use PuthDuskAssertions;
    
    protected string $baseUrl = 'https://example.cypress.io/';
    
    public function testAssertTitle()
    {
        $this->assertTitle('Cypress.io: Kitchen Sink');
    }
    
    public function testAssertTitleContains()
    {
        $this->assertTitleContains('Kitchen Sink');
    }
    
    public function testAssertSee()
    {
        $this->assertSee('Commands');
    }
    
    public function testAssertDontSee()
    {
        $this->assertDontSee('Commandss');
    }
    
    public function testAssertSeeIn()
    {
        $this->assertSeeIn('#utilities', 'Commands');
    }
    
    public function testAssertDontSeeIn()
    {
        $this->assertDontSeeIn('.banner', 'Commands');
    }
    
    public function testAssertSourceHas()
    {
        $this->assertSourceHas('<title>Cypress.io: Kitchen Sink</title>');
    }
    
    public function testAssertSourceMissing()
    {
        $this->assertSourceMissing('<div>__not in dom__</div>');
    }
    
    public function testAssertSeeLink()
    {
        $this->assertSeeLink('https://www.cypress.io');
    }
    
    public function testAssertDontSeeLink()
    {
        $this->assertDontSeeLink('https://notalink.io');
    }
    
    public function testAssertVisible()
    {
        $this->assertVisible('body');
    }
    
    public function testAssertVisibleElement()
    {
        $this->assertVisible($this->page->get('body'));
    }
    
    public function testAssertInputValue()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $input = $this->page->get('input');
        $input->type('puth test type');
        
        $this->assertInputValue($input, 'puth test type');
    }
    
    public function testAssertInputValueIsNot()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $input = $this->page->get('input');
        $input->type('puth test type');
        
        $this->assertInputValueIsNot($input, 'not the typed value');
    }
    
    public function testAssertChecked()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $checkbox = $this->page->get('input[type="checkbox"]');
        $checkbox->click();
        
        $this->assertChecked($checkbox);
    }
    
    public function testAssertNotChecked()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $checkbox = $this->page->get('input[type="checkbox"]');
        
        $this->assertNotChecked($checkbox);
    }
    
    public function testAssertRadioSelected()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $radio = $this->page->get('input[type="radio"]');
        $radio->click();
        
        $this->assertRadioSelected($radio);
    }
    
    public function testAssertRadioNotSelected()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $radio = $this->page->get('input[type="radio"]');
        
        $this->assertRadioNotSelected($radio);
    }
    
    public function testAssertSelected()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $select = $this->page->get('select');
        $select->select('fr-apples');
        
        $this->assertSelected($select, 'fr-apples');
    }
    
    public function testAssertNotSelected()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $select = $this->page->get('select');
        $select->select('fr-apples');
        
        $this->assertNotSelected($select, 'fr-oranges');
    }
    
    public function testAssertSelectHasOptions()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $select = $this->page->get('select');
        
        $this->assertSelectHasOptions(
            $select,
            [
                '--Select a fruit--',
                'fr-apples',
                'fr-oranges',
                'fr-bananas',
            ]
        );
    }
    
    public function testAssertSelectMissingOptions()
    {
        // $this->page->goto('https://example.cypress.io/commands/actions');
        // TODO assertSelectMissingOptions
    }
    
    public function testAssertSelectHasOption()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $this->assertSelectHasOptions(
            $this->page->get('select'),
            ['fr-bananas']
        );
    }
    
    public function testAssertSelectMissingOption()
    {
        // $this->page->goto('https://example.cypress.io/commands/actions');
        // TODO assertSelectMissingOption
    }
    
    public function testAssertValue()
    {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $input = $this->page->get('input');
        $input->type('puth test type');
        
        $this->assertValue($input, 'puth test type');
    }
    
    public function testAssertAttribute()
    {
        $this->assertAttribute(
            $this->page->get('a'),
            'href',
            'https://example.cypress.io/'
        );
    }
    
    public function testAssertDataAttribute() {
        // TODO implement
    }
    
    public function testAssertAriaAttribute() {
        // TODO implement
    }
    
    public function testAssertPresent() {
        $this->assertPresent('body');
    }
    
    public function testAssertMissing() {
        $this->assertMissing('missingelement');
    }
    
    public function testDialogOpened() {
        // TODO implement
    }
    
    public function testAssertEnabled() {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $this->assertEnabled($this->page->get('input'));
    }
    
    public function testAssertDisabled() {
        $this->page->goto('https://example.cypress.io/commands/actions');
        
        $this->assertDisabled($this->page->get('input[disabled]'));
    }
    
    public function testAssertButtonEnabled() {
        // TODO write test
    }
    
    public function testAssertButtonDisabled() {
        // TODO write test
    }
    
    public function testAssertFocused() {
        // TODO implement
    }
    
    public function testAssertNotFocused() {
        // TODO implement
    }
    
    public function testAssertScript() {
        $this->assertScript('1+1', 2);
    }
}