<?php

/*
 * Some code in this file is part of PHP CS Fixer.
 *
 * Copyright (c) 2012-2022 Fabien Potencier, Dariusz Rumiński
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Major\CS\Tests;

use Exception;
use InvalidArgumentException;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use PhpCsFixer\FixerDefinition\FileSpecificCodeSampleInterface;
use PhpCsFixer\FixerDefinition\VersionSpecificCodeSampleInterface;
use PhpCsFixer\Linter;
use PhpCsFixer\PhpunitConstraintIsIdenticalString\Constraint\IsIdenticalString;
use PhpCsFixer\StdinFileInfo;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

abstract class FixerTestCase extends TestCase
{
    use AssertTokens;

    private Linter\LinterInterface $linter;

    protected FixerInterface $fixer;

    abstract protected function createFixer(): FixerInterface;

    abstract public function testName(): void;

    protected function setUp(): void
    {
        parent::setUp();

        $this->linter = $this->getLinter();
        $this->fixer = $this->createFixer();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->linter, $this->fixer);
    }

    final public function testIsRisky(): void
    {
        if ($this->fixer->isRisky()) {
            self::assertNotNull($description = $this->fixer->getDefinition()->getRiskyDescription());
            self::assertValidDescription($this->fixer->getName(), 'risky description', $description);
        } else {
            static::assertNull($this->fixer->getDefinition()->getRiskyDescription(), "[{$this->fixer->getName()}] Fixer is not risky so no description of it expected.");
        }
    }

    final public function testFixerDefinitions(): void
    {
        $fixerName = $this->fixer->getName();
        $definition = $this->fixer->getDefinition();

        self::assertValidDescription($fixerName, 'summary', $definition->getSummary());

        $samples = $definition->getCodeSamples();
        static::assertNotEmpty($samples, "[{$fixerName}] Code samples are required.");

        $dummyFileInfo = new StdinFileInfo();

        foreach ($samples as $sampleCounter => $sample) {
            $code = $sample->getCode();

            static::assertNotEmpty($code, "[{$fixerName}] Sample #{$sampleCounter}");

            if (! $this->fixer instanceof SingleBlankLineAtEofFixer) {
                static::assertStringEndsWith("\n", $code, "[{$fixerName}] Sample #{$sampleCounter} must end with linebreak");
            }

            if ($sample instanceof VersionSpecificCodeSampleInterface && ! $sample->isSuitableFor(PHP_VERSION_ID)) {
                continue;
            }

            if ($this->fixer instanceof ConfigurableFixerInterface) {
                // always re-configure as the fixer might have been configured with diff. configuration form previous sample
                $this->fixer->configure($sample->getConfiguration() ?? []);
            }

            Tokens::clearCache();
            $tokens = Tokens::fromCode($code);
            $this->fixer->fix(
                $sample instanceof FileSpecificCodeSampleInterface ? $sample->getSplFileInfo() : $dummyFileInfo,
                $tokens,
            );

            static::assertTrue($tokens->isChanged(), "[{$fixerName}] Sample #{$sampleCounter} is not changed during fixing.");
        }
    }

    protected function doTest(string $expected, ?string $input = null): void
    {
        if ($expected === $input) {
            throw new InvalidArgumentException('Input parameter must not be equal to expected parameter.');
        }

        $file = $this->getTestFile();
        $fileIsSupported = $this->fixer->supports($file);

        if ($input !== null) {
            static::assertNull($this->lintSource($input));

            Tokens::clearCache();
            $tokens = Tokens::fromCode($input);

            if ($fileIsSupported) {
                static::assertTrue($this->fixer->isCandidate($tokens), 'Fixer must be a candidate for input code.');
                static::assertFalse($tokens->isChanged(), 'Fixer must not touch Tokens on candidate check.');
                $this->fixer->fix($file, $tokens);
            }

            static::assertThat($tokens->generateCode(), new IsIdenticalString($expected), 'Code build on input code must match expected code.');
            static::assertTrue($tokens->isChanged(), 'Tokens collection built on input code must be marked as changed after fixing.');

            $tokens->clearEmptyTokens();

            static::assertSame(
                count($tokens),
                count(array_unique(array_map(
                    static fn (Token $token): string => spl_object_hash($token),
                    $tokens->toArray(),
                ))),
                'Token items inside Tokens collection must be unique.',
            );

            Tokens::clearCache();
            $expectedTokens = Tokens::fromCode($expected);
            self::assertTokens($expectedTokens, $tokens);
        }

        static::assertNull($this->lintSource($expected));

        Tokens::clearCache();
        $tokens = Tokens::fromCode($expected);

        if ($fileIsSupported) {
            $this->fixer->fix($file, $tokens);
        }

        static::assertThat($tokens->generateCode(), new IsIdenticalString($expected), 'Code build on expected code must not change.');
        static::assertFalse($tokens->isChanged(), 'Tokens collection built on expected code must not be marked as changed after fixing.');
    }

    private function getTestFile(): SplFileInfo
    {
        /** @var array<string, SplFileInfo> $files */
        static $files = [];

        return $files[__FILE__] ??= new SplFileInfo(__FILE__);
    }

    private function lintSource(string $source): ?string
    {
        try {
            $this->linter->lintSource($source)->check();
        } catch (Exception $e) {
            return $e->getMessage() . "\n\nSource:\n{$source}";
        }

        return null;
    }

    private function getLinter(): Linter\LinterInterface
    {
        /** @var ?Linter\Linter $linter */
        static $linter = null;

        return $linter ??= new Linter\Linter();
    }

    private static function assertValidDescription(string $name, string $type, string $description): void
    {
        self::assertMatchesRegularExpression('/^[A-Z`][^"]+\\.$/', $description, "[{$name}] The {$type} must start with capital letter or a ` and end with dot.");
        self::assertStringNotContainsString('phpdocs', $description, "[{$name}] The {$type} must start with capital letter or a ` and end with dot.");
        self::assertCorrectCasing($description, 'PHPDoc', "[{$name}] The {$type} must start with capital letter or a ` and end with dot.");
        self::assertCorrectCasing($description, 'PHPUnit', "[{$name}] The {$type} must start with capital letter or a ` and end with dot.");
        self::assertFalse(strpos($type, '``'), "[{$name}] The {$type} must start with capital letter or a ` and end with dot.");
    }

    private static function assertCorrectCasing(string $needle, string $haystack, string $message): void
    {
        static::assertSame(
            substr_count(strtolower($haystack), strtolower($needle)),
            substr_count($haystack, $needle),
            $message,
        );
    }
}
