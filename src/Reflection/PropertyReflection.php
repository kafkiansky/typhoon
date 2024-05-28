<?php

declare(strict_types=1);

namespace Typhoon\Reflection;

use Typhoon\DeclarationId\PropertyId;
use Typhoon\Reflection\Internal\Data;
use Typhoon\Reflection\Internal\NativeAdapter\PropertyAdapter;
use Typhoon\Reflection\Internal\Visibility;
use Typhoon\Type\Type;
use Typhoon\TypedMap\TypedMap;

/**
 * @api
 * @readonly
 * @extends Reflection<PropertyId>
 */
final class PropertyReflection extends Reflection
{
    /**
     * @var non-empty-string
     */
    public readonly string $name;

    /**
     * @var AttributeReflection[]
     * @psalm-var AttributeReflections
     * @phpstan-var AttributeReflections
     */
    public readonly AttributeReflections $attributes;

    public function __construct(PropertyId $id, TypedMap $data, Reflector $reflector)
    {
        $this->name = $id->name;
        $this->attributes = new AttributeReflections($id, $data[Data::Attributes], $reflector);

        parent::__construct($id, $data, $reflector);
    }

    /**
     * @return ?non-empty-string
     */
    public function phpDoc(): ?string
    {
        return $this->data[Data::PhpDoc];
    }

    public function file(): ?string
    {
        if ($this->data[Data::InternallyDefined]) {
            return null;
        }

        return $this->declaringClass()->file();
    }

    public function class(): ClassReflection
    {
        return $this->reflector->reflect($this->id->class);
    }

    public function isStatic(): bool
    {
        return $this->data[Data::Static];
    }

    public function isPromoted(): bool
    {
        return $this->data[Data::Promoted];
    }

    public function defaultValue(): mixed
    {
        return $this->data[Data::DefaultValueExpression]?->evaluate($this, $this->reflector);
    }

    public function hasDefaultValue(): bool
    {
        return $this->data[Data::DefaultValueExpression] !== null;
    }

    public function isPrivate(): bool
    {
        return $this->data[Data::Visibility] === Visibility::Private;
    }

    public function isProtected(): bool
    {
        return $this->data[Data::Visibility] === Visibility::Protected;
    }

    public function isPublic(): bool
    {
        $visibility = $this->data[Data::Visibility];

        return $visibility === null || $visibility === Visibility::Public;
    }

    public function isReadonly(Kind $kind = Kind::Resolved): bool
    {
        return match ($kind) {
            Kind::Native => $this->data[Data::NativeReadonly],
            Kind::Annotated => $this->data[Data::AnnotatedReadonly],
            Kind::Resolved => $this->data[Data::NativeReadonly] || $this->data[Data::AnnotatedReadonly],
        };
    }

    /**
     * @return ($kind is Kind::Resolved ? Type : ?Type)
     */
    public function type(Kind $kind = Kind::Resolved): ?Type
    {
        return $this->data[Data::Type]->byKind($kind);
    }

    public function toNative(): \ReflectionProperty
    {
        return new PropertyAdapter($this, $this->reflector);
    }

    private function declaringClass(): ClassReflection
    {
        return $this->reflector->reflect($this->data[Data::DeclaringClassId]);
    }
}
