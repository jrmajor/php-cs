<?php

namespace Major\CS\Tests\Fixers;

use Generator;
use Major\CS\Fixers\NoWhitespaceInEmptyArray;
use Major\CS\Tests\FixerTestCase;
use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\Attributes\DataProvider;

final class NoWhitespaceInEmptyArrayTest extends FixerTestCase
{
    protected function createFixer(): FixerInterface
    {
        return new NoWhitespaceInEmptyArray();
    }

    public function testName(): void
    {
        $this->assertSame('Major/no_whitespace_in_empty_array', $this->fixer->getName());
    }

    #[DataProvider('provideFixCases')]
    public function testFix(string $expected, ?string $input = null): void
    {
        $this->doTest($expected, $input);
    }

    public static function provideFixCases(): Generator
    {
        yield [
            "<?php\n\n\$foo = [];\n",
            "<?php\n\n\$foo = [\n];\n",
        ];

        yield [
            "<?php\n\n\$foo = [];\n",
            "<?php\n\n\$foo = [      ];\n",
        ];

        yield [
            "<?php\n\n\$foo = [];\n",
            "<?php\n\n\$foo = [\n\n];\n",
        ];

        yield [
            "<?php\n\n\$foo = [\n    // foo\n];\n",
        ];

        yield [
            "<?php\n\n\$foo = [];\n",
            "<?php\n\n\$foo = [\n    \n];\n",
        ];

        yield [
            "<?php\n\n\$foo = [ /* test */ ];\n",
        ];

        yield [
            <<<'PHP'
                <?php class Foo {
                    private const Foo = [];
                }
                PHP,
            <<<'PHP'
                <?php class Foo {
                    private const Foo = [
                    ];
                }
                PHP,
        ];

        yield [
            <<<'PHP'
                <?php class Foo {
                    public function bar(): void {
                        $foo = [];
                    }
                }
                PHP,
            <<<'PHP'
                <?php class Foo {
                    public function bar(): void {
                        $foo = [   ];
                    }
                }
                PHP,
        ];

        yield [
            <<<'PHP'
                <?php class Foo {
                    public array $ignore = [];
                }
                PHP,
            <<<'PHP'
                <?php class Foo {
                    public array $ignore = [
                    ];
                }
                PHP,
        ];
    }
}
