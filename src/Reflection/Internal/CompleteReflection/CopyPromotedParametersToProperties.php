<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\CompleteReflection;

use Typhoon\DeclarationId\AnonymousClassId;
use Typhoon\DeclarationId\AnonymousFunctionId;
use Typhoon\DeclarationId\NamedClassId;
use Typhoon\DeclarationId\NamedFunctionId;
use Typhoon\Reflection\Internal\ClassKind;
use Typhoon\Reflection\Internal\Data;
use Typhoon\Reflection\Internal\DataReflector;
use Typhoon\Reflection\Internal\ReflectionHook;
use Typhoon\TypedMap\TypedMap;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 */
final class CopyPromotedParametersToProperties implements ReflectionHook
{
    public function reflect(NamedFunctionId|AnonymousFunctionId|NamedClassId|AnonymousClassId $id, TypedMap $data, DataReflector $reflector): TypedMap
    {
        if ($id instanceof NamedFunctionId || $id instanceof AnonymousFunctionId) {
            return $data;
        }

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
