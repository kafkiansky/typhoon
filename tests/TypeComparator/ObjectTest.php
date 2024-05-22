<?php

declare(strict_types=1);

namespace Typhoon\TypeComparator;

use PHPUnit\Framework\Attributes\CoversClass;
use Typhoon\Type\Type;
use Typhoon\Type\types;

#[CoversClass(IsObject::class)]
#[CoversClass(ComparatorSelector::class)]
final class ObjectTest extends AtomicRelationTestCase
{
    protected static function type(): Type
    {
        return types::object;
    }

    protected static function subtypes(): iterable
    {
        yield types::object;
        yield types::never;
        yield types::object(\stdClass::class);
        yield types::objectShape(['a' => types::string]);
        yield types::closure;
    }

    protected static function nonSubtypes(): iterable
    {
        yield types::void;
        yield types::true;
        yield types::false;
        yield types::bool;
        yield types::int;
        yield types::literalInt;
        yield types::positiveInt;
        yield types::negativeInt;
        yield types::intMask(types::intValue(0));
        yield types::arrayKey;
        yield types::float;
        yield types::string;
        yield types::nonEmptyString;
        yield types::classString;
        yield types::literalString;
        yield types::truthyString;
        yield types::numericString;
        yield types::array;
        yield types::iterable;
        yield types::callable;
        yield types::resource;
        yield types::intersection(types::callable, types::string);
        yield types::mixed;
        yield types::union(types::never, types::string);
    }
}
