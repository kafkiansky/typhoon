<?php

declare(strict_types=1);

namespace Typhoon\Type\Internal;

use Typhoon\DeclarationId\TemplateId;
use Typhoon\Type\Type;
use Typhoon\Type\TypeVisitor;

/**
 * @internal
 * @psalm-internal Typhoon\Type
 * @psalm-immutable
 * @implements Type<mixed>
 */
final class TemplateType implements Type
{
    public function __construct(
        private readonly TemplateId $template,
    ) {}

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->template($this, $this->template);
    }
}
