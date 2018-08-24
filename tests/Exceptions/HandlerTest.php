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

    public function testConsoleHandlerErrorBasic()
    {
        $handler = new ConsoleHandler();
        $handler->setColorsSupport(true);
        $result = $handler->renderException(new \Error("message", 100), HandlerInterface::VERBOSITY_BASIC);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }

    public function testConsoleHandlerErrorVerbose()
    {
        $handler = new ConsoleHandler();
        $handler->setColorsSupport(true);
        $result = $handler->renderException(new \Error("message", 100), HandlerInterface::VERBOSITY_VERBOSE);

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

    public function testHtmlHandlerDefaultBasic()
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

    public function testHtmlHandlerInvertedBasic()
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

    public function testConsoleHandlerWithColorsDebug()
    {
        $handler = new ConsoleHandler();
        $handler->setColorsSupport(true);

        $result = $handler->renderException(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        ), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }

    public function testHtmlHandlerDefaultDebug()
    {
        $handler = new HtmlHandler(HtmlHandler::DEFAULT);

        $result = $handler->renderException(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        ), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }

    public function testHtmlHandlerInvertedDebug()
    {
        $handler = new HtmlHandler(HtmlHandler::INVERTED);

        $result = $handler->renderException(new Error(
            "message",
            100,
            __FILE__,
            __LINE__
        ), HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("Error", $result);
        $this->assertContains("message", $result);
        $this->assertContains(__FILE__, $result);
    }

    public function testConsoleHandlerStacktrace()
    {
        $handler = new ConsoleHandler();
        $handler->setColorsSupport(true);

        try {
            $this->makeException();
        } catch (\Throwable $e) {

        }

        $result = $handler->renderException($e, HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("LogicException", $result);
        $this->assertContains("makeException", $result);
    }

    public function testHtmlHandlerStacktrace()
    {
        $handler = new HtmlHandler(HtmlHandler::DEFAULT);

        try {
            $this->makeException();
        } catch (\Throwable $e) {

        }

        $result = $handler->renderException($e, HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("RuntimeException", $result);
        $this->assertContains("LogicException", $result);
        $this->assertContains("makeException", $result);
    }

    public function testHtmlHandlerInvertedStacktrace()
    {
        $handler = new HtmlHandler(HtmlHandler::INVERTED);

        try {
            $this->makeException();
        } catch (\Throwable $e) {

        }

        $result = $handler->renderException($e, HandlerInterface::VERBOSITY_DEBUG);

        $this->assertContains("RuntimeException", $result);
        $this->assertContains("LogicException", $result);
        $this->assertContains("makeException", $result);
    }

    function makeException()
    {
        try {
            $f = function () {
                throw new \RuntimeException("error");
            };

            $f();
        } catch (\Throwable $e) {
            throw new \LogicException("error", 0, $e);
        }
    }
}