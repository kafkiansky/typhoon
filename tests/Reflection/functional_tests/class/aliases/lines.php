<?php

declare(strict_types=1);

namespace Typhoon\Reflection;

use function PHPUnit\Framework\assertSame;

return static function (TyphoonReflector $reflector): void {
    $aliases = $reflector
        ->withResource(new Resource(<<<'PHP'
            <?php
            /** 
             * @psalm-type First = string
             * @phpstan-type Second = int
             */
            class A {}
            PHP))
        ->reflectClass('A')
        ->aliases();

    assertSame(3, $aliases['First']->startLine());
    assertSame(3, $aliases['First']->endLine());
    assertSame(4, $aliases['Second']->startLine());
    assertSame(4, $aliases['Second']->endLine());
};