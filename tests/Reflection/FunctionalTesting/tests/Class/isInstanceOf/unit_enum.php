<?php

declare(strict_types=1);

namespace Typhoon\Reflection\FunctionalTesting;

use Typhoon\Reflection\TyphoonReflector;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;
use function Typhoon\DeclarationId\classId;

return static function (TyphoonReflector $reflector): void {
    $reflection = $reflector->reflectCode('<?php enum A {}')[classId('A')];

    assertFalse($reflection->isInstanceOf(\Iterator::class));
    assertFalse($reflection->isInstanceOf(\stdClass::class));
    assertTrue($reflection->isInstanceOf('A'));
    assertTrue($reflection->isInstanceOf(\UnitEnum::class));
    assertFalse($reflection->isInstanceOf(\BackedEnum::class));
};
