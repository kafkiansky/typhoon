<?php

declare(strict_types=1);

namespace Typhoon\Reflection\NameContext;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(UnqualifiedName::class)]
final class UnqualifiedNameTest extends TestCase
{
    /**
     * @return \Generator<int, array{string}>
     */
    public static function validNames(): \Generator
    {
        yield ['A'];
        yield ['a'];
        yield ['a123'];
        yield ['Привет'];
        yield ['ÿ'];
        yield ['🤪'];
    }

    /**
     * @return \Generator<int, array{string}>
     */
    public static function invalidNames(): \Generator
    {
        yield [''];
        yield ['1'];
        yield ['a\\b'];
    }

    #[DataProvider('validNames')]
    public function testItConstructorAcceptsValidNames(string $name): void
    {
        new UnqualifiedName($name);

        $this->expectNotToPerformAssertions();
    }

    #[DataProvider('invalidNames')]
    public function testItCannotBeCreatedFromInvalidNames(string $name): void
    {
        $this->expectExceptionObject(new InvalidName(sprintf('"%s" is not a valid PHP label', $name)));

        new UnqualifiedName($name);
    }

    #[DataProvider('validNames')]
    public function testToStringReturnsSameName(string $name): void
    {
        $unqualifiedName = new UnqualifiedName($name);

        $nameAsString = $unqualifiedName->toString();

        self::assertSame($name, $nameAsString);
    }

    #[DataProvider('validNames')]
    public function testLastSegmentReturnsThis(string $name): void
    {
        $unqualifiedName = new UnqualifiedName($name);

        $lastSegment = $unqualifiedName->lastSegment();

        self::assertSame($name, $lastSegment->toString());
    }

    #[DataProvider('validNames')]
    public function testItResolvesToItselfInGlobalNamespace(string $name): void
    {
        $unqualifiedName = new UnqualifiedName($name);

        $resolved = $unqualifiedName->resolve();

        self::assertSame($name, $resolved->toString());
    }

    #[DataProvider('validNames')]
    public function testItPrependsNamespace(string $name): void
    {
        $unqualifiedName = new UnqualifiedName($name);

        $resolved = $unqualifiedName->resolve(new UnqualifiedName('B'));

        self::assertSame('B\\' . $name, $resolved->toString());
    }
}
