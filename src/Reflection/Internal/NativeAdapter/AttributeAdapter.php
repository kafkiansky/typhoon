<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\NativeAdapter;

use Typhoon\DeclarationId\AnonymousClassId;
use Typhoon\DeclarationId\ClassConstantId;
use Typhoon\DeclarationId\ClassId;
use Typhoon\DeclarationId\FunctionId;
use Typhoon\DeclarationId\MethodId;
use Typhoon\DeclarationId\ParameterId;
use Typhoon\DeclarationId\PropertyId;
use Typhoon\Reflection\AttributeReflection;
use Typhoon\Reflection\AttributeReflections;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 * @template TAttribute of object
 * @extends \ReflectionAttribute<TAttribute>
 */
final class AttributeAdapter extends \ReflectionAttribute
{
    public function __construct(
        private readonly AttributeReflection $reflection,
    ) {}

    /**
     * @return list<\ReflectionAttribute>
     */
    public static function from(AttributeReflections $attributes, ?string $name = null, int $flags = 0): array
    {
        if ($name !== null) {
            if ($flags & \ReflectionAttribute::IS_INSTANCEOF) {
                $attributes = $attributes->instanceOf($name);
            } else {
                $attributes = $attributes->class($name);
            }
        }

        return $attributes->map(static fn(AttributeReflection $attribute): \ReflectionAttribute => $attribute->toNative());
    }

    public function __toString(): string
    {
        // TODO
        return '';
    }

    public function getArguments(): array
    {
        return $this->reflection->arguments();
    }

    public function getName(): string
    {
        return $this->reflection->className();
    }

    public function getTarget(): int
    {
        /** @psalm-suppress ParadoxicalCondition */
        return match ($this->reflection->targetId::class) {
            FunctionId::class => \Attribute::TARGET_FUNCTION,
            ParameterId::class => \Attribute::TARGET_PARAMETER,
            ClassId::class, AnonymousClassId::class => \Attribute::TARGET_CLASS,
            ClassConstantId::class => \Attribute::TARGET_CLASS_CONSTANT,
            PropertyId::class => \Attribute::TARGET_PROPERTY,
            MethodId::class => \Attribute::TARGET_METHOD,
        };
    }

    public function isRepeated(): bool
    {
        return $this->reflection->isRepeated();
    }

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public function newInstance(): object
    {
        return $this->reflection->newInstance();
    }
}
