<?php

declare(strict_types=1);

namespace Typhoon\Reflection;

use Typhoon\Reflection\Reflector\FriendlyReflection;
use Typhoon\Reflection\TypeResolver\ClassTemplateResolver;
use Typhoon\Reflection\TypeResolver\StaticResolver;

/**
 * @api
 */
final class ParameterReflection extends FriendlyReflection
{
    /**
     * @internal
     * @psalm-internal Typhoon\Reflection
     * @param callable-string|array{class-string, non-empty-string} $function
     * @param int<0, max> $position
     * @param non-empty-string $name
     * @param ?positive-int $startLine
     * @param ?positive-int $endLine
     */
    public function __construct(
        private readonly string|array $function,
        private readonly int $position,
        public readonly string $name,
        private readonly bool $passedByReference,
        private readonly bool $defaultValueAvailable,
        private readonly bool $optional,
        private readonly bool $variadic,
        private readonly bool $promoted,
        private readonly bool $deprecated,
        /** @readonly */
        private TypeReflection $type,
        private readonly ?int $startLine,
        private readonly ?int $endLine,
        private ?\ReflectionParameter $nativeReflection = null,
    ) {}

    public function canBePassedByValue(): bool
    {
        return !$this->passedByReference;
    }

    public function getDefaultValue(): mixed
    {
        return $this->getNativeReflection()->getDefaultValue();
    }

    /**
     * @return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int<0, max>
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    public function getType(): TypeReflection
    {
        return $this->type;
    }

    public function isDefaultValueAvailable(): bool
    {
        return $this->defaultValueAvailable;
    }

    public function isOptional(): bool
    {
        return $this->optional;
    }

    public function isPassedByReference(): bool
    {
        return $this->passedByReference;
    }

    public function isPromoted(): bool
    {
        return $this->promoted;
    }

    public function isVariadic(): bool
    {
        return $this->variadic;
    }

    public function isDeprecated(): bool
    {
        return $this->deprecated;
    }

    public function __serialize(): array
    {
        $data = get_object_vars($this);
        unset($data['nativeReflection']);

        return $data;
    }

    public function __unserialize(array $data): void
    {
        foreach ($data as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * @return ?positive-int
     */
    public function getStartLine(): ?int
    {
        return $this->startLine;
    }

    /**
     * @return ?positive-int
     */
    public function getEndLine(): ?int
    {
        return $this->endLine;
    }

    public function __clone()
    {
        if ((debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['class'] ?? null) !== self::class) {
            throw new ReflectionException();
        }
    }

    public function getNativeReflection(): \ReflectionParameter
    {
        return $this->nativeReflection ??= new \ReflectionParameter($this->function, $this->name);
    }

    public function resolvedTypes(ClassTemplateResolver|StaticResolver $typeResolver): self
    {
        $parameter = clone $this;
        $parameter->type = $this->type->resolve($typeResolver);

        return $parameter;
    }

    protected function toChildOf(FriendlyReflection $parent): static
    {
        $parameter = clone $this;
        $parameter->type = $this->type->toChildOf($parent->type);

        return $parameter;
    }
}
