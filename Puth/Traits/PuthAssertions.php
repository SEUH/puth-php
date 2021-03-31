<?php

namespace Puth\Traits;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\Comparator\ComparisonFailure;

trait PuthAssertions
{
    function assertElementEquals($element1, $element2)
    {
        $assertion = $this->context->assertStrictEqual($element1, $element2);
        
        if ($assertion->result === false) {
            $expectedString = "Generic({$element1->getRepresents()}, {$element1->getId()})";
            $actualString = "Generic({$element2->getRepresents()}, {$element2->getId()})";
            
            throw new ExpectationFailedException(
                "Expected element [{$expectedString}] to be [{$actualString}]",
                new ComparisonFailure($expectedString, $actualString, $expectedString, $actualString),
            );
        }
        
        Assert::assertEquals(1,1);
    }
}