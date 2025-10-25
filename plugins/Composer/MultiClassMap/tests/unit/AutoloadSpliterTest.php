<?php

declare(strict_types=1);

namespace Ziumper\MultiClassMap\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Ziumper\MultiClassMap\AutoloadSpliter;

class AutoloadSpliterTest extends TestCase 
{
    public function testAutoloadPartsClassMap(): void 
    {
        $spliter = new AutoloadSpliter(__DIR__."/../fixtures/test_vendor");
        $parts = $spliter->getClassMapParts();
        static::assertNotEmpty($parts);
    }
}
