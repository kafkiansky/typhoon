<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Metadata;

use Typhoon\Reflection\Inheritance\MethodsInheritanceResolver;
use Typhoon\Reflection\Inheritance\PropertiesInheritanceResolver;
use Typhoon\Reflection\TemplateReflection;
use Typhoon\Type\NamedObjectType;
use Typhoon\Type\Type;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 * @template-covariant T of object
 * @template-extends RootMetadata<class-string<T>>
 * @psalm-suppress PossiblyUnusedProperty
 */
final class ClassMetadata extends RootMetadata
{
    /**
     * @var ?array<non-empty-string, PropertyMetadata>
     */
    private ?array $resolvedProperties = null;

    /**
     * @var ?array<non-empty-string, MethodMetadata>
     */
    private ?array $resolvedMethods = null;

    /**
     * @param class-string<T> $name
     * @param non-empty-string|false $extension
     * @param non-empty-string|false $file
     * @param positive-int|false $startLine
     * @param positive-int|false $endLine
     * @param non-empty-string|false $docComment
     * @param list<AttributeMetadata> $attributes
     * @param array<non-empty-string, Type> $typeAliases
     * @param list<TemplateReflection> $templates
     * @param int-mask-of<\ReflectionClass::IS_*> $modifiers
     * @param list<NamedObjectType> $interfaceTypes
     * @param list<NamedObjectType> $traitTypes
     * @param list<PropertyMetadata> $ownProperties
     * @param list<MethodMetadata> $ownMethods
     */
    public function __construct(
        string $name,
        public readonly int $modifiers,
        ChangeDetector $changeDetector,
        public readonly bool $internal = false,
        public readonly string|false $extension = false,
        public readonly string|false $file = false,
        public readonly int|false $startLine = false,
        public readonly int|false $endLine = false,
        public readonly string|false $docComment = false,
        public readonly array $attributes = [],
        public readonly array $typeAliases = [],
        public readonly array $templates = [],
        public readonly bool $interface = false,
        public readonly bool $enum = false,
        public readonly bool $trait = false,
        public readonly bool $anonymous = false,
        public readonly bool $deprecated = false,
        public readonly ?NamedObjectType $parentType = null,
        public readonly array $interfaceTypes = [],
        public readonly array $traitTypes = [],
        public readonly array $ownProperties = [],
        public readonly array $ownMethods = [],
    ) {
        parent::__construct($name, $changeDetector);
    }

    /**
     * @param \Closure(class-string): ClassMetadata $classMetadataReflector
     * @return array<non-empty-string, PropertyMetadata>
     */
    public function resolvedProperties(\Closure $classMetadataReflector): array
    {
        if ($this->resolvedProperties !== null) {
            return $this->resolvedProperties;
        }

        $resolver = new PropertiesInheritanceResolver($this->name, $classMetadataReflector);
        $resolver->setOwn($this->ownProperties);
        $resolver->addUsed(...$this->traitTypes);
        if ($this->parentType !== null) {
            $resolver->addInherited($this->parentType);
        }

        return $this->resolvedProperties = $resolver->resolve();
    }

    /**
     * @param \Closure(class-string): ClassMetadata $classMetadataReflector
     * @return array<non-empty-string, MethodMetadata>
     */
    public function resolvedMethods(\Closure $classMetadataReflector): array
    {
        if ($this->resolvedMethods !== null) {
            return $this->resolvedMethods;
        }

        $resolver = new MethodsInheritanceResolver($this->name, $classMetadataReflector);
        $resolver->setOwn($this->ownMethods);
        $resolver->addUsed(...$this->traitTypes);
        if ($this->parentType !== null) {
            $resolver->addInherited($this->parentType);
        }
        $resolver->addInherited(...$this->interfaceTypes);

        return $this->resolvedMethods = $resolver->resolve();
    }

    public function __serialize(): array
    {
        $data = get_object_vars($this);
        unset($data['resolvedProperties'], $data['resolvedMethods']);

        return $data;
    }
}
