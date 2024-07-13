<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\PhpDoc;

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser as PHPStanPhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection\Internal\PhpDoc
 */
final class PhpDocParser
{
    private readonly Lexer $lexer;

    private readonly PHPStanPhpDocParser $parser;

    public function __construct(
        private readonly PhpDocTagPrioritizer $tagPrioritizer = new PrefixBasedPhpDocTagPrioritizer(),
        bool $lines = true,
    ) {
        $this->lexer = new Lexer();
        $constExprParser = new ConstExprParser();
        $this->parser = new PHPStanPhpDocParser(
            typeParser: new TypeParser($constExprParser),
            constantExprParser: $constExprParser,
            usedAttributes: ['lines' => $lines],
        );
    }

    public function parse(string $comment): PhpDoc
    {
        $tokens = $this->lexer->tokenize($comment);
        $phpDoc = $this->parser->parse(new TokenIterator($tokens));

        return new PhpDoc($this->tagPrioritizer, $phpDoc->getTags());
    }
}