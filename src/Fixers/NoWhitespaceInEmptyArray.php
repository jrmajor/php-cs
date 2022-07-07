<?php

namespace Major\CS\Fixers;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

final class NoWhitespaceInEmptyArray extends AbstractFixer
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Empty arrays should not be multiline.',
            [new CodeSample("<?php\n\n\$foo = [\n];\n")],
        );
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(CT::T_ARRAY_SQUARE_BRACE_OPEN);
    }

    /**
     * Must run after ArraySyntaxFixer, NoEmptyCommentFixer.
     */
    public function getPriority(): int
    {
        return 3;
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = count($tokens) - 1; $index > 0; $index--) {
            if (! $tokens[$index]->isGivenKind(CT::T_ARRAY_SQUARE_BRACE_CLOSE)) {
                continue;
            }

            if ($tokens->getPrevNonWhitespace($index) !== $index - 2) {
                continue;
            }

            if (! $tokens[$index - 2]->isGivenKind(CT::T_ARRAY_SQUARE_BRACE_OPEN)) {
                continue;
            }

            $tokens->clearAt($index - 1);
        }
    }
}
