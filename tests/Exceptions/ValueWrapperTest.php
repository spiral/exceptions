<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\Debug\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Debug\Dumper;
use Spiral\Debug\Renderer\PlainRenderer;
use Spiral\Exceptions\HandlerInterface;
use Spiral\Exceptions\ValueWrapper;

class ValueWrapperTest extends TestCase
{
    public function testInteger(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains('100', join(',', $wrapper->wrap([100])));
    }

    public function testString(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains('string', join(',', $wrapper->wrap(['hello world'])));
    }

    public function testArray(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains('array', join(',', $wrapper->wrap([['hello world']])));
    }

    public function testNull(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains('null', join(',', $wrapper->wrap([null])));
    }

    public function testBool(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains('true', join(',', $wrapper->wrap([true])));
        $this->assertContains('false', join(',', $wrapper->wrap([false])));
    }

    public function testObject(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains('Dumper', join(',', $wrapper->wrap([new Dumper()])));
    }

    public function testDoNotAggregateValues(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains('100', join(',', $wrapper->wrap([100])));
        $this->assertCount(0, $wrapper->getValues());
    }

    public function testAggregateValues(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains('string', join(',', $wrapper->wrap(['hello'])));
        $this->assertCount(1, $wrapper->getValues());
    }

    public function testAggregateMultipleValues(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains('string', join(',', $wrapper->wrap(['hello'])));
        $this->assertContains('string', join(',', $wrapper->wrap(['hello'])));
        $this->assertContains('string', join(',', $wrapper->wrap(['hello'])));
        $this->assertContains('string', join(',', $wrapper->wrap(['hello'])));

        $this->assertCount(1, $wrapper->getValues());
    }

    public function testAggregateValuesInline(): void
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains('100', join(',', $wrapper->wrap([100])));
        $this->assertCount(0, $wrapper->getValues());
    }
}
