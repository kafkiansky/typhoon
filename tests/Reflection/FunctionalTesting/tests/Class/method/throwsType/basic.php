<?php

declare(strict_types=1);

namespace Typhoon\Reflection\FunctionalTesting;

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
                 * @throws LogicException|RuntimeException
                 * @throws Exception
                 */
                public function a(): string;
            }
            PHP,
    )[classId('A')]->methods['a'];

    assertEquals(
        types::union(
            types::union(types::object(\LogicException::class), types::object(\RuntimeException::class)),
            types::object(\Exception::class),
        ),
        $reflection->throwsType(),
    );
};
