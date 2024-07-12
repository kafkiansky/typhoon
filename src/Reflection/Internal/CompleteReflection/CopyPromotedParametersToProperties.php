<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\CompleteReflection;

use Typhoon\DeclarationId\AnonymousClassId;
use Typhoon\DeclarationId\NamedClassId;
use Typhoon\Reflection\ClassKind;
use Typhoon\Reflection\Internal\ClassReflectionHook;
use Typhoon\Reflection\Internal\Data;
use Typhoon\Reflection\Internal\DataReflector;
use Typhoon\Reflection\Internal\TypedMap\TypedMap;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 */
final class CopyPromotedParametersToProperties implements ClassReflectionHook
{
    public function process(NamedClassId|AnonymousClassId $id, TypedMap $data, DataReflector $reflector): TypedMap
    {
        $classKind = $data[Data::ClassKind];

        if ($classKind === ClassKind::Enum || $classKind === ClassKind::Interface) {
            return $data;
        }

        $methods = $data[Data::Methods];

        if (!isset($methods['__construct'])) {
            return $data;
        }

        $properties = $data[Data::Properties];

        foreach ($methods['__construct'][Data::Parameters] as $name => $parameter) {
            if ($parameter[Data::Promoted]) {
                $properties[$name] = $parameter;
            }
        }

        return $data->set(Data::Properties, $properties);
    }
}
