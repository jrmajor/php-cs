<?php

namespace Major\CS\Tests\Fixers;

use Generator;
use Major\CS\Fixers\SingleLineEmptyBody;
use Major\CS\Tests\FixerTestCase;
use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * This test is copied from PHP-CS-Fixer repository with only minor changes,
 * and falls under its license, which can be found under a link below.
 *
 * @see https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/8ac301a/tests/Fixer/Basic/SingleLineEmptyBodyFixerTest.php
 * @see https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/8ac301a/LICENSE
 */
final class SingleLineEmptyBodyTest extends FixerTestCase
{
    protected function createFixer(): FixerInterface
    {
        return new SingleLineEmptyBody();
    }

    public function testName(): void
    {
        $this->assertSame('Major/single_line_empty_body', $this->fixer->getName());
    }

    #[DataProvider('provideFixCases')]
    public function testFix(string $expected, ?string $input = null): void
    {
        $this->doTest($expected, $input);
    }

    public static function provideFixCases(): Generator
    {
        yield 'non-anonymous classes' => [
            "<?php class Foo\n{\n}",
        ];

        yield 'non-anonymous functions' => [
            "<?php function foo()\n{\n}",
        ];

        yield 'non-empty class' => [
            <<<'PHP'
                <?php
                new class()
                {
                    public function bar () { }
                };
                PHP,
        ];

        yield 'non-empty functions' => [
            <<<'PHP'
                <?php
                function ()
                { /* foo */ };
                function ()
                { /** foo */ };
                function ()
                { // foo
                };
                function ()
                {
                    return true;
                };
                PHP,
        ];

        yield 'classes' => [
            <<<'PHP'
                <?php
                new class () { };
                new class() extends BarParent { };
                new class () implements BazInteface { };
                PHP,
            <<<'PHP'
                <?php
                new class ()
                {
                };
                new class() extends BarParent
                {};
                new class () implements BazInteface    {};
                PHP,
        ];

        yield 'multiple functions' => [
            <<<'PHP'
                <?php
                function ()    { return 1; };
                function foo(
                ) { }
                function () { };
                function () { };
                function (){ return 1; };
                PHP,
            <<<'PHP'
                <?php
                function ()    { return 1; };
                function foo(
                )
                {}
                function () {
                };
                function ()
                {
                };
                function (){ return 1; };
                PHP,
        ];

        yield 'ensure single space' => [
            <<<'PHP'
                <?php
                function () { };
                function foo(
                ) { }
                function () { };
                PHP,
            <<<'PHP'
                <?php
                function () {};
                function foo(
                ) {  }
                function () {    };
                PHP,
        ];

        yield 'add spaces' => [
            <<<'PHP'
                <?php
                function () { };
                function foo(
                ) { }
                function () { };
                PHP,
            <<<'PHP'
                <?php
                function (){ };
                function foo(
                ){ }
                function (){ };
                PHP,
        ];

        yield 'with return types' => [
            <<<'PHP'
                <?php
                function (): void { };
                function foo(
                ): \Foo\Bar { }
                function (): ?string { };
                PHP,
            <<<'PHP'
                <?php
                function (): void
                {};
                function foo(
                ): \Foo\Bar    {    }
                function (): ?string {
                };
                PHP,
        ];

        yield 'every token in separate line' => [
            <<<'PHP'
                <?php
                function
                (
                )
                :
                void { };
                PHP,
            <<<'PHP'
                <?php
                function
                (
                )
                :
                void
                {
                };
                PHP,
        ];

        yield 'comments before body' => [
            <<<'PHP'
                <?php
                function ()
                // foo
                { };
                function ()
                /* foo */
                { };
                function foo(
                )
                /** foo */
                { }
                function ()
                /** foo */
                /** bar */
                { };
                PHP,
            <<<'PHP'
                <?php
                function ()
                // foo
                {
                };
                function ()
                /* foo */
                {
                };
                function foo(
                )
                /** foo */
                {
                }
                function ()
                /** foo */
                /** bar */
                {    };
                PHP,
        ];

        yield 'single-line arguments method' => [
            <<<'PHP'
                <?php
                class Foo
                {
                    public function __construct(private int $x, private int $y)
                    {
                    }
                }
                PHP,
        ];

        yield 'multi-line arguments method' => [
            <<<'PHP'
                <?php
                class Foo
                {
                    public function __construct(
                        private int $x,
                        private int $y,
                    ) { }
                }
                PHP,
            <<<'PHP'
                <?php
                class Foo
                {
                    public function __construct(
                        private int $x,
                        private int $y,
                    ) {
                    }
                }
                PHP,
        ];

        yield 'single-line arguments function' => [
            <<<'PHP'
                <?php
                function foo(int $foo)
                {
                }
                PHP,
        ];

        yield 'multi-line arguments function' => [
            <<<'PHP'
                <?php
                function foo(
                    int $foo,
                ) { }
                PHP,
            <<<'PHP'
                <?php
                function foo(
                    int $foo,
                ) {
                }
                PHP,
        ];
    }
}
