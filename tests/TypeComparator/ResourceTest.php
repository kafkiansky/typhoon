<?php

declare(strict_types=1);

namespace Typhoon\TypeComparator;

use PHPUnit\Framework\Attributes\CoversClass;
use Typhoon\Type\Type;
use Typhoon\Type\types;

#[CoversClass(IsResource::class)]
#[CoversClass(ComparatorSelector::class)]
final class ResourceTest extends AtomicRelationTestCase
{
    protected static function type(): Type
    {
        return types::resource;
    }

    protected static function subtypes(): iterable
    {
        yield types::resource;
        yield types::never;
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
        yield types::object;
        yield types::callable;
        yield types::closure;
        yield types::intersection(types::callable, types::string);
        yield types::mixed;
        yield types::union(types::never, types::string);
    }
}
