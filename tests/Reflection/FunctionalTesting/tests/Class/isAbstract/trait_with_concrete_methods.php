<?php

declare(strict_types=1);

namespace Typhoon\Reflection\FunctionalTesting;

use Typhoon\Reflection\TyphoonReflector;
use function PHPUnit\Framework\assertFalse;

return (new TestBuilder())
    ->code(
        <<<'PHP'
            trait A
            {
                public function x(): void {}
            }
            PHP,
    )
    ->test(static function (TyphoonReflector $reflector): void {
        $reflection = $reflector->reflectClass('A');

        assertFalse($reflection->isAbstract());
    });