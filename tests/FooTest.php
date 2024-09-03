<?php

namespace Jrf\PHPUnit1011\Example\Tests;

use Exception;
use Jrf\PHPUnit1011\Example\Foo;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\TestCase;

#[CoversTrait(Foo::class)]
#[CoversClass(Foo::class)]
final class FooTest extends TestCase
{
    use Foo;

    public function testDoSomething()
    {
        $this->assertTrue($this->doSomething());
    }
}
