<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Debug\Tests;

use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;
use Spiral\Exceptions\ConsoleHandler;
use Spiral\Exceptions\HandlerInterface;
use Spiral\Exceptions\HtmlHandler;

class HandlerTest extends TestCase
{
    public function testGetMessage()
    {
        $handler = new ConsoleHandler();

        $this->assertContains("Error", $handler->getMessage(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        )));

        $this->assertContains("message", $handler->getMessage(new Error("message",
            100,
            __FILE__,
            __LINE__
        )));

        $this->assertContains(__FILE__, $handler->getMessage(new Error("message",
            100,
            __FILE__,
            __LINE__
        )));

        $this->assertContains("100", $handler->getMessage(new Error("message",
            100,
            __FILE__,
            100
        )));
    }

    public function testConsoleHandlerWithoutColorsBasic()
    {
        $handler = new ConsoleHandler();
        $handler->setColorsSupport(false);

        $result = $handler->renderException(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        ), HandlerInterface::VERBOSITY_BASIC);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }

    public function testConsoleHandlerWithColorsBasic()
    {
        $handler = new ConsoleHandler();
        $handler->setColorsSupport(true);

        $result = $handler->renderException(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        ), HandlerInterface::VERBOSITY_BASIC);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }

    public function testHtmlHandlerDefault()
    {
        $handler = new HtmlHandler(HtmlHandler::DEFAULT);

        $result = $handler->renderException(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        ), HandlerInterface::VERBOSITY_BASIC);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }

    public function testHtmlHandlerInverted()
    {
        $handler = new HtmlHandler(HtmlHandler::INVERTED);

        $result = $handler->renderException(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        ), HandlerInterface::VERBOSITY_BASIC);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }
}