<?php

declare(strict_types=1);

namespace Typhoon\ChangeDetector;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ComposerPackageChangeDetector::class)]
final class ComposerPackageChangeDetectorTest extends TestCase
{
    public function testItDetectsPackageRefChange(): void
    {
        $changeDetector = new ComposerPackageChangeDetector('nikic/php-parser', 'fake-ref');

        $changed = $changeDetector->changed();

        self::assertTrue($changed);
    }

    public function testItReturnsDeduplicatedDetectors(): void
    {
        $detector = ChangeDetectors::from([
            new ComposerPackageChangeDetector('nikic/php-parser', '0.3.0'),
            ComposerPackageChangeDetector::fromName('nikic/php-parser'),
            ComposerPackageChangeDetector::fromName('psr/simple-cache'),
        ]);

        $deduplicated = $detector->deduplicate();

        self::assertCount(3, $deduplicated);
    }
}
