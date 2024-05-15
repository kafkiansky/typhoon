<?php

declare(strict_types=1);

namespace Typhoon\Reflection\FunctionalTesting;

use Typhoon\Reflection\Kind;
use Typhoon\Reflection\TyphoonReflector;
use Typhoon\Type\types;
use function PHPUnit\Framework\assertEquals;
use function Typhoon\DeclarationId\classId;

return static function (TyphoonReflector $reflector): void {
    $reflection = $reflector->reflectCode(
        <<<'PHP'
            <?php
            
            interface A
            {
                /**
                 * @return non-empty-string
                 */
                public function a(): string;
            }
            PHP,
    )[classId('A')]->methods['a'];

    assertEquals(types::string, $reflection->returnType(Kind::Native));
    assertEquals(types::nonEmptyString, $reflection->returnType(Kind::Annotated));
    assertEquals(types::nonEmptyString, $reflection->returnType(Kind::Resolved));
};
