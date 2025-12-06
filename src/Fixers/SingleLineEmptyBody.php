<?php

namespace Major\CS\Fixers;

use InvalidArgumentException;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;
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
        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (
                $tokens[$index]->isGivenKind([T_CLASS])
                && $this->shouldFixClass($index, $tokens)
            ) {
                $this->doFix($index, $tokens);
            }

            if (
                $tokens[$index]->isGivenKind([T_FUNCTION])
                && $this->shouldFixFunction($index, $tokens)
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

    private function shouldFixFunction(int $index, Tokens $tokens): bool
    {
        $nextIndex = $tokens->getNextMeaningfulToken($index);
        assert($nextIndex !== null);

        if ($tokens[$nextIndex]->equals('(')) {
            return true;
        }

        $argListStart = $tokens->getNextTokenOfKind($index, ['(']);

        assert($argListStart !== null);

        return $this->isBlockMultiline($tokens, $argListStart);
    }

    private function isBlockMultiline(Tokens $tokens, int $index): bool
    {
        $blockType = Tokens::detectBlockType($tokens[$index]);

        if ($blockType === null || ! $blockType['isStart']) {
            throw new InvalidArgumentException("There is no block start at index {$index}.");
        }

        $endIndex = $tokens->findBlockEnd($blockType['type'], $index);

        for (++$index; $index < $endIndex; $index++) {
            $token = $tokens[$index];
            $blockType = Tokens::detectBlockType($token);

            if ($blockType !== null && $blockType['isStart']) {
                $index = $tokens->findBlockEnd($blockType['type'], $index);

                continue;
            }

            if (
                $token->isWhitespace()
                && ! $tokens[$index - 1]->isGivenKind(T_END_HEREDOC)
                && str_contains($token->getContent(), "\n")
            ) {
                return true;
            }
        }

        return false;
    }

    private function doFix(int $index, Tokens $tokens): void
    {
        $openBraceIndex = $tokens->getNextTokenOfKind($index, ['{', ';']);

        if ($openBraceIndex === null || ! $tokens[$openBraceIndex]->equals('{')) {
            return;
        }

        $closeBraceIndex = $tokens->getNextNonWhitespace($openBraceIndex);
        assert($closeBraceIndex !== null);

        if (! $tokens[$closeBraceIndex]->equals('}')) {
            return;
        }

        $tokens->ensureWhitespaceAtIndex($openBraceIndex + 1, 0, ' ');

        $beforeOpenBraceIndex = $tokens->getPrevNonWhitespace($openBraceIndex);
        assert($beforeOpenBraceIndex !== null);

        if (! $tokens[$beforeOpenBraceIndex]->isGivenKind([T_COMMENT, T_DOC_COMMENT])) {
            $tokens->ensureWhitespaceAtIndex($openBraceIndex - 1, 1, ' ');
        }
    }
}
