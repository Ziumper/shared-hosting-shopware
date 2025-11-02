<?php

declare(strict_types=1);

namespace Ziumper\MultiClassMap\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Ziumper\MultiClassMap\AutoloadSpliter;

class AutoloadSpliterTest extends TestCase 
{
    //TODO interpolate the correct path in future to be not hardcoded
    private string $vendorDir = "/var/www/html/custom/composer-plugins/MultiClassMap/tests/fixtures/test_vendor/"; 
    
    public function testAutoloadPartsClassMap(): void 
    {
        $spliter = new AutoloadSpliter($this->vendorDir);
        $parts = $spliter->getClassMapParts();
        static::assertNotEmpty($parts);
        static::assertCount(307, $parts);
    }

    public function testAutoloadPathContainsVendorDir() {
        $spliter = new AutoloadSpliter($this->vendorDir);
        $parts = $spliter->getClassMapParts();
        static::assertNotEmpty($parts);
        $element = array_pop($parts);
        static::assertNotEmpty($element, "The part element should not be empty");
        $path = array_values($element)[0];
        static::assertNotEmpty($path, " The path should not be empty");
        static::assertStringNotContainsString($this->vendorDir, $path, "There is a vendor folder inside!");
    }
}
