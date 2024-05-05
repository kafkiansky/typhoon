<?php

declare(strict_types=1);

namespace Typhoon\Reflection\FunctionalTesting;

use Typhoon\Reflection\TyphoonReflector;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

return (new TestBuilder())
    ->code(
        <<<'PHP'
            interface I1 {}
            interface I2 extends I1 {}
            abstract class A1 {}
            abstract class A2 extends A1 implements I2 {}
            class X extends A2 {}
            PHP,
    )
    ->test(static function (TyphoonReflector $reflector): void {
        $reflection = $reflector->reflectClass('X');

        assertFalse($reflection->isInstanceOf(\Iterator::class));
        assertFalse($reflection->isInstanceOf(\stdClass::class));
        assertTrue($reflection->isInstanceOf('X'));
        assertTrue($reflection->isInstanceOf('A1'));
        assertTrue($reflection->isInstanceOf('A2'));
        assertTrue($reflection->isInstanceOf('I1'));
        assertTrue($reflection->isInstanceOf('I2'));
    });