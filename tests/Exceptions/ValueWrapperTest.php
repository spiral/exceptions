<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Debug\Tests;


use PHPUnit\Framework\TestCase;
use Spiral\Debug\Dumper;
use Spiral\Debug\Renderer\PlainRenderer;
use Spiral\Exceptions\HandlerInterface;
use Spiral\Exceptions\ValueWrapper;

class ValueWrapperTest extends TestCase
{
    public function testInteger()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains("100", join(",", $wrapper->wrap([100])));
    }

    public function testString()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains("string", join(",", $wrapper->wrap(["hello world"])));
    }

    public function testArray()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains("array", join(",", $wrapper->wrap([["hello world"]])));
    }

    public function testObject()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains("Dumper", join(",", $wrapper->wrap([new Dumper()])));
    }


    public function testDoNotAggregateValues()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), 0);

        $this->assertContains("100", join(",", $wrapper->wrap([100])));
        $this->assertCount(0, $wrapper->getValues());
    }

    public function testAggregateValues()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("string", join(",", $wrapper->wrap(["hello"])));
        $this->assertCount(1, $wrapper->getValues());
    }

    public function testAggregateMultipleValues()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("string", join(",", $wrapper->wrap(["hello"])));
        $this->assertContains("string", join(",", $wrapper->wrap(["hello"])));
        $this->assertContains("string", join(",", $wrapper->wrap(["hello"])));
        $this->assertContains("string", join(",", $wrapper->wrap(["hello"])));

        $this->assertCount(1, $wrapper->getValues());
    }

    public function testAggregateValuesInline()
    {
        $wrapper = new ValueWrapper(new Dumper(), new PlainRenderer(), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("100", join(",", $wrapper->wrap([100])));
        $this->assertCount(0, $wrapper->getValues());
    }
}