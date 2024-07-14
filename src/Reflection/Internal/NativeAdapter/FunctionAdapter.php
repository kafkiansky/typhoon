<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\NativeAdapter;

use Typhoon\Reflection\FunctionReflection;
use Typhoon\Reflection\Internal\Data\Data;
use Typhoon\Reflection\Kind;
use Typhoon\Reflection\ParameterReflection;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 * @property-read non-empty-string $name
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class FunctionAdapter extends \ReflectionFunction
{
    public const ANONYMOUS_FUNCTION_NAME = '{closure}';

    public function __construct(
        private readonly FunctionReflection $reflection,
    ) {
        unset($this->name);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function __get(string $name)
    {
        return match ($name) {
            'name' => $this->getName(),
            default => new \LogicException(sprintf('Undefined property %s::$%s', self::class, $name)),
        };
    }

    public function __isset(string $name): bool
    {
        return $name === 'name';
    }

    public function __toString(): string
    {
        $this->loadNative();

        return parent::__toString();
    }

    public function getAttributes(?string $name = null, int $flags = 0): array
    {
        return AttributeAdapter::fromList($this->reflection->attributes(), $name, $flags);
    }

    public function getClosure(): \Closure
    {
        $this->loadNative();

        return parent::getClosure();
    }

    public function getClosureCalledClass(): ?\ReflectionClass
    {
        return null;
    }

    public function getClosureScopeClass(): ?\ReflectionClass
    {
        return null;
    }

    public function getClosureThis(): ?object
    {
        return null;
    }

    public function getClosureUsedVariables(): array
    {
        return [];
    }

    public function getDocComment(): string|false
    {
        return $this->reflection->phpDoc() ?? false;
    }

    public function getEndLine(): int|false
    {
        return $this->reflection->endLine() ?? false;
    }

    public function getExtension(): ?\ReflectionExtension
    {
        $extension = $this->reflection->extension();

        if ($extension === null) {
            return null;
        }

        return new \ReflectionExtension($extension);
    }

    public function getExtensionName(): string|false
    {
        return $this->reflection->extension() ?? false;
    }

    public function getFileName(): string|false
    {
        return $this->reflection->file() ?? false;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType
     */
    public function getName(): string
    {
        if ($this->reflection->name !== null) {
            return $this->reflection->name;
        }

        $namespace = $this->reflection->namespace();

        if ($namespace === '') {
            return self::ANONYMOUS_FUNCTION_NAME;
        }

        return $namespace . '\\' . self::ANONYMOUS_FUNCTION_NAME;
    }

    public function getNamespaceName(): string
    {
        return $this->reflection->namespace();
    }

    public function getNumberOfParameters(): int
    {
        return $this->reflection->parameters()->count();
    }

    public function getNumberOfRequiredParameters(): int
    {
        return $this
            ->reflection
            ->parameters()
            ->filter(static fn(ParameterReflection $reflection): bool => !$reflection->isOptional())
            ->count();
    }

    /**
     * @return list<\ReflectionParameter>
     */
    public function getParameters(): array
    {
        return $this
            ->reflection
            ->parameters()
            ->map(static fn(ParameterReflection $parameter): \ReflectionParameter => $parameter->toNative())
            ->toList();
    }

    public function getReturnType(): ?\ReflectionType
    {
        return $this->reflection->returnType(Kind::Native)?->accept(new ToNativeTypeConverter());
    }

    public function getShortName(): string
    {
        if ($this->reflection->name === null) {
            return self::ANONYMOUS_FUNCTION_NAME;
        }

        return $this->reflection->shortName();
    }

    public function getStartLine(): int|false
    {
        return $this->reflection->startLine() ?? false;
    }

    public function getStaticVariables(): array
    {
        $this->loadNative();

        return parent::getStaticVariables();
    }

    public function getTentativeReturnType(): ?\ReflectionType
    {
        return $this->reflection->data[Data::Type]->tentative?->accept(new ToNativeTypeConverter());
    }

    public function hasReturnType(): bool
    {
        return $this->reflection->returnType(Kind::Native) !== null;
    }

    public function hasTentativeReturnType(): bool
    {
        return $this->reflection->data[Data::Type]->tentative !== null;
    }

    public function inNamespace(): bool
    {
        return $this->reflection->namespace() !== '';
    }

    public function invoke(mixed ...$args): mixed
    {
        $this->loadNative();

        return parent::invoke(...$args);
    }

    public function invokeArgs(array $args = []): mixed
    {
        $this->loadNative();

        return parent::invokeArgs($args);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod, UnusedPsalmSuppress
     */
    public function isAnonymous(): bool
    {
        return $this->reflection->isAnonymous();
    }

    public function isDisabled(): bool
    {
        $this->loadNative();

        return parent::isDisabled();
    }

    public function isClosure(): bool
    {
        return false;
    }

    public function isDeprecated(): bool
    {
        return false;
    }

    public function isGenerator(): bool
    {
        return $this->reflection->isGenerator();
    }

    public function isInternal(): bool
    {
        return $this->reflection->isInternallyDefined();
    }

    public function isStatic(): bool
    {
        return $this->reflection->isStatic();
    }

    public function isUserDefined(): bool
    {
        return !$this->isInternal();
    }

    public function isVariadic(): bool
    {
        return $this->reflection->isVariadic();
    }

    public function returnsReference(): bool
    {
        return $this->reflection->returnsReference();
    }

    private bool $nativeLoaded = false;

    private function loadNative(): void
    {
        if ($this->nativeLoaded) {
            return;
        }

        $name = $this->reflection->name ?? throw new \LogicException(sprintf(
            'Cannot natively reflect %s',
            $this->reflection->id->toString(),
        ));

        parent::__construct($name);
        $this->nativeLoaded = true;
    }
}