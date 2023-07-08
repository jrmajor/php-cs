<?php

namespace Major\CS\Fixers;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\TokensAnalyzer;
use SplFileInfo;

final class SingleLineEmptyBody extends AbstractFixer
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Empty body of an anonymous construct must be abbreviated as `{ }`.',
            [new CodeSample("<?php\n\nfunction ()\n{\n};\n")],
        );
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAnyTokenKindsFound([T_CLASS, T_FUNCTION]);
    }

    /**
     * Must run after ClassDefinitionFixer, CurlyBracesPositionFixer.
     */
    public function getPriority(): int
    {
        return -3;
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        $analyzer = new TokensAnalyzer($tokens);

        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (
                $tokens[$index]->isGivenKind([T_CLASS])
                && $this->shouldFixClass($index, $tokens)
            ) {
                $this->doFix($index, $tokens);
            }

            if (
                $tokens[$index]->isGivenKind([T_FUNCTION])
                && $this->shouldFixFunction($index, $tokens, $analyzer)
            ) {
                $this->doFix($index, $tokens);
            }
        }
    }

    private function shouldFixClass(int $index, Tokens $tokens): bool
    {
        $previousIndex = $tokens->getPrevMeaningfulToken($index);

        assert($previousIndex !== null);

        return $tokens[$previousIndex]->isGivenKind(T_NEW);
    }

    private function shouldFixFunction(
        int $index,
        Tokens $tokens,
        TokensAnalyzer $analyzer,
    ): bool {
        $nextIndex = $tokens->getNextMeaningfulToken($index);

        if ($tokens[$nextIndex]->equals('(')) {
            return true;
        }

        $argListStart = $tokens->getNextTokenOfKind($index, ['(']);

        assert($argListStart !== null);

        return $analyzer->isBlockMultiline($tokens, $argListStart);
    }

    private function doFix(int $index, Tokens $tokens): void
    {
        $openBraceIndex = $tokens->getNextTokenOfKind($index, ['{', ';']);

        if ($openBraceIndex === null || ! $tokens[$openBraceIndex]->equals('{')) {
            return;
        }

        $closeBraceIndex = $tokens->getNextNonWhitespace($openBraceIndex);

        if (! $tokens[$closeBraceIndex]->equals('}')) {
            return;
        }

        $tokens->ensureWhitespaceAtIndex($openBraceIndex + 1, 0, ' ');

        $beforeOpenBraceIndex = $tokens->getPrevNonWhitespace($openBraceIndex);

        if (! $tokens[$beforeOpenBraceIndex]->isGivenKind([T_COMMENT, T_DOC_COMMENT])) {
            $tokens->ensureWhitespaceAtIndex($openBraceIndex - 1, 1, ' ');
        }
    }
}
