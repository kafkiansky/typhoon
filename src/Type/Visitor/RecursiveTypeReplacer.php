<?php

declare(strict_types=1);

namespace Typhoon\Type\Visitor;

use Typhoon\DeclarationId\AliasId;
use Typhoon\DeclarationId\ClassId;
use Typhoon\DeclarationId\NamedClassId;
use Typhoon\Type\Argument;
use Typhoon\Type\ArrayElement;
use Typhoon\Type\Parameter;
use Typhoon\Type\Property;
use Typhoon\Type\Type;
use Typhoon\Type\types;
use Typhoon\Type\Variance;

/**
 * @api
 * @extends DefaultTypeVisitor<Type>
 * @todo optimize by using type classes directly
 */
abstract class RecursiveTypeReplacer extends DefaultTypeVisitor
{
    public function alias(Type $type, AliasId $alias, array $typeArguments): mixed
    {
        return types::alias($alias, ...$this->processTypes($typeArguments));
    }

    public function array(Type $type, Type $keyType, Type $valueType, array $elements): mixed
    {
        return types::arrayShape(
            elements: array_map(
                fn(ArrayElement $element): ArrayElement => types::arrayElement(
                    $element->type->accept($this),
                    $element->optional,
                ),
                $elements,
            ),
            key: $keyType->accept($this),
            value: $valueType->accept($this),
        );
    }

    public function callable(Type $type, array $parameters, Type $returnType): mixed
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
            return: $returnType->accept($this),
        );
    }

    public function classConstant(Type $type, Type $classType, string $name): mixed
    {
        return types::classConstant($classType->accept($this), $name);
    }

    public function conditional(Type $type, Argument|Type $subject, Type $ifType, Type $thenType, Type $elseType): mixed
    {
        return types::conditional($subject, $ifType->accept($this), $thenType->accept($this), $elseType->accept($this));
    }

    public function intersection(Type $type, array $ofTypes): mixed
    {
        return types::intersection(...$this->processTypes($ofTypes));
    }

    public function intMask(Type $type, Type $ofType): mixed
    {
        return types::intMask($ofType->accept($this));
    }

    public function iterable(Type $type, Type $keyType, Type $valueType): mixed
    {
        return types::iterable($keyType->accept($this), $valueType->accept($this));
    }

    public function key(Type $type, Type $arrayType): mixed
    {
        return types::key($arrayType->accept($this));
    }

    public function list(Type $type, Type $valueType, array $elements): mixed
    {
        return types::listShape(
            elements: array_map(
                fn(ArrayElement $element): ArrayElement => types::arrayElement(
                    $element->type->accept($this),
                    $element->optional,
                ),
                $elements,
            ),
            value: $valueType->accept($this),
        );
    }

    public function literal(Type $type, Type $ofType): mixed
    {
        return types::literal($ofType->accept($this));
    }

    public function namedObject(Type $type, ClassId $class, array $typeArguments): mixed
    {
        return types::object($class, ...$this->processTypes($typeArguments));
    }

    public function object(Type $type, array $properties): mixed
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

    public function offset(Type $type, Type $arrayType, Type $keyType): mixed
    {
        return types::offset($arrayType->accept($this), $keyType->accept($this));
    }

    public function self(Type $type, ?ClassId $resolvedClass, array $typeArguments): mixed
    {
        return types::self($resolvedClass, ...$this->processTypes($typeArguments));
    }

    public function parent(Type $type, ?NamedClassId $resolvedClass, array $typeArguments): mixed
    {
        return types::parent($resolvedClass, ...$this->processTypes($typeArguments));
    }

    public function static(Type $type, ?ClassId $resolvedClass, array $typeArguments): mixed
    {
        return types::static($resolvedClass, ...$this->processTypes($typeArguments));
    }

    public function union(Type $type, array $ofTypes): mixed
    {
        return types::union(...$this->processTypes($ofTypes));
    }

    public function not(Type $type, Type $ofType): mixed
    {
        return types::not($ofType->accept($this));
    }

    public function varianceAware(Type $type, Type $ofType, Variance $variance): mixed
    {
        return types::varianceAware($ofType->accept($this), $variance);
    }

    /**
     * @param list<Type> $types
     * @return list<Type>
     */
    final protected function processTypes(array $types): array
    {
        return array_map(fn(Type $type): Type => $type->accept($this), $types);
    }

    protected function default(Type $type): mixed
    {
        return $type;
    }
}
