<?php

declare(strict_types=1);

namespace Typhoon\Type\Visitor;

use Typhoon\Type\Argument;
use Typhoon\Type\ArrayElement;
use Typhoon\Type\At;
use Typhoon\Type\AtClass;
use Typhoon\Type\AtFunction;
use Typhoon\Type\AtMethod;
use Typhoon\Type\Parameter;
use Typhoon\Type\Property;
use Typhoon\Type\Type;
use Typhoon\Type\types;
use Typhoon\Type\Variance;

/**
 * @api
 * @extends DefaultTypeVisitor<Type>
 */
abstract class RecursiveTypeReplacer extends DefaultTypeVisitor
{
    public function alias(Type $self, string $name, string $class, array $arguments): mixed
    {
        return types::alias($name, $class, ...$this->processTypes($arguments));
    }

    public function array(Type $self, Type $key, Type $value, array $elements): mixed
    {
        return types::arrayShape(
            elements: array_map(
                fn(ArrayElement $element): ArrayElement => types::arrayElement(
                    $element->type->accept($this),
                    $element->optional,
                ),
                $elements,
            ),
            key: $key->accept($this),
            value: $value->accept($this),
        );
    }

    public function callable(Type $self, array $parameters, Type $return): mixed
    {
        return types::callable(
            parameters: array_map(
                fn(Parameter $parameter): Parameter => types::param(
                    type: $parameter->type->accept($this),
                    hasDefault: $parameter->hasDefault,
                    variadic: $parameter->variadic,
                    byReference: $parameter->byReference,
                    name: $parameter->name,
                ),
                $parameters,
            ),
            return: $return->accept($this),
        );
    }

    public function classConstant(Type $self, Type $class, string $name): mixed
    {
        return types::classConstant($class->accept($this), $name);
    }

    public function closure(Type $self, array $parameters, Type $return): mixed
    {
        return types::closure(
            parameters: array_map(
                fn(Parameter $parameter): Parameter => types::param(
                    type: $parameter->type->accept($this),
                    hasDefault: $parameter->hasDefault,
                    variadic: $parameter->variadic,
                    byReference: $parameter->byReference,
                    name: $parameter->name,
                ),
                $parameters,
            ),
            return: $return->accept($this),
        );
    }

    public function conditional(Type $self, Argument|Type $subject, Type $if, Type $then, Type $else): mixed
    {
        return types::conditional($subject, $if->accept($this), $then->accept($this), $else->accept($this));
    }

    public function intersection(Type $self, array $types): mixed
    {
        return types::intersection(...$this->processTypes($types));
    }

    public function intMask(Type $self, Type $type): mixed
    {
        return types::intMask($type->accept($this));
    }

    public function iterable(Type $self, Type $key, Type $value): mixed
    {
        return types::iterable($key->accept($this), $value->accept($this));
    }

    public function key(Type $self, Type $type): mixed
    {
        return types::key($type->accept($this));
    }

    public function list(Type $self, Type $value, array $elements): mixed
    {
        return types::listShape(
            elements: array_map(
                fn(ArrayElement $element): ArrayElement => types::arrayElement(
                    $element->type->accept($this),
                    $element->optional,
                ),
                $elements,
            ),
            value: $value->accept($this),
        );
    }

    public function literal(Type $self, Type $type): mixed
    {
        return types::literal($type->accept($this));
    }

    public function namedObject(Type $self, string $class, array $arguments): mixed
    {
        return types::object($class, ...$this->processTypes($arguments));
    }

    public function nonEmpty(Type $self, Type $type): mixed
    {
        return types::nonEmpty($type->accept($this));
    }

    public function objectShape(Type $self, array $properties): mixed
    {
        return types::objectShape(
            array_map(
                fn(Property $property): Property => types::prop(
                    $property->type->accept($this),
                    $property->optional,
                ),
                $properties,
            ),
        );
    }

    public function offset(Type $self, Type $type, Type $offset): mixed
    {
        return types::offset($type->accept($this), $offset->accept($this));
    }

    public function static(Type $self, string $class, array $arguments): mixed
    {
        return types::static($class, ...$this->processTypes($arguments));
    }

    public function template(Type $self, string $name, At|AtFunction|AtClass|AtMethod $declaredAt, array $arguments): mixed
    {
        return types::template($name, $declaredAt, ...$this->processTypes($arguments));
    }

    public function union(Type $self, array $types): mixed
    {
        return types::union(...$this->processTypes($types));
    }

    public function varianceAware(Type $self, Type $type, Variance $variance): mixed
    {
        return types::varianceAware($type->accept($this), $variance);
    }

    /**
     * @param list<Type> $types
     * @return list<Type>
     */
    final protected function processTypes(array $types): array
    {
        return array_map(fn(Type $type): Type => $type->accept($this), $types);
    }

    protected function default(Type $self): mixed
    {
        return $self;
    }
}