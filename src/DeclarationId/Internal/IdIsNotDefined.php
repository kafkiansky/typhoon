<?php

declare(strict_types=1);

namespace Typhoon\DeclarationId\Internal;

use Typhoon\DeclarationId\Id;

/**
 * @internal
 * @psalm-internal Typhoon
 */
final class IdIsNotDefined extends \RuntimeException
{
    public function __construct(Id $id)
    {
        parent::__construct(\sprintf('%s is not defined in the IdMap', $id->describe()));
    }
}
