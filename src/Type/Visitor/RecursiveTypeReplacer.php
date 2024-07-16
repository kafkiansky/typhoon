<?php

declare(strict_types=1);

namespace Typhoon\Type\Visitor;

use Typhoon\DeclarationId\AliasId;
use Typhoon\DeclarationId\AnonymousClassId;
use Typhoon\DeclarationId\NamedClassId;
use Typhoon\Type\Argument;
use Typhoon\Type\Parameter;
use Typhoon\Type\ShapeElement;
use Typhoon\Type\Type;
use Typhoon\Type\types;
use Typhoon\Type\Variance;

/**
 * @api
 * @extends DefaultTypeVisitor<Type>
 */
abstract class RecursiveTypeReplacer extends DefaultTypeVisitor
{
    public function alias(Type $type, AliasId $alias, array $typeArguments): mixed
    {
        return types::alias($alias, $this->processTypes($typeArguments));
    }

    public function array(Type $type, Type $keyType, Type $valueType, array $elements): mixed
    {
        return types::unsealedArrayShape(
            elements: array_map(
                fn(ShapeElement $element): ShapeElement => new ShapeElement(
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

    public function classConstantMask(Type $type, Type $classType, string $namePrefix): mixed
    {
        return types::classConstantMask($classType->accept($this), $namePrefix);
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
        return types::intMaskOf($ofType->accept($this));
    }

    public function iterable(Type $type, Type $keyType, Type $valueType): mixed
    {
        return types::iterable($keyType->accept($this), $valueType->accept($this));
    }

    public function key(Type $type, Type $arrayType): mixed
    {
        return types::keyOf($arrayType->accept($this));
    }

    public function list(Type $type, Type $valueType, array $elements): mixed
    {
        return types::unsealedListShape(
            elements: array_map(
                fn(ShapeElement $element): ShapeElement => new ShapeElement(
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

    public function namedObject(Type $type, NamedClassId $class, array $typeArguments): mixed
    {
        return types::object($class, $this->processTypes($typeArguments));
    }

    public function object(Type $type, array $properties): mixed
    {
        return types::objectShape(
            array_map(
                fn(ShapeElement $property): ShapeElement => new ShapeElement(
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

    public function self(Type $type, null|NamedClassId|AnonymousClassId $resolvedClass, array $typeArguments): mixed
    {
        return types::self($this->processTypes($typeArguments), $resolvedClass);
    }

    public function parent(Type $type, ?NamedClassId $resolvedClass, array $typeArguments): mixed
    {
        return types::parent($this->processTypes($typeArguments), $resolvedClass);
    }

    public function static(Type $type, null|NamedClassId|AnonymousClassId $resolvedClass, array $typeArguments): mixed
    {
        return types::static($this->processTypes($typeArguments), $resolvedClass);
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
