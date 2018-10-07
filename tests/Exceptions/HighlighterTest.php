<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Debug\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Exceptions\Highlighter;
use Spiral\Exceptions\Style\ConsoleStyle;
use Spiral\Exceptions\Style\HtmlStyle;
use Spiral\Exceptions\Style\PlainStyle;

class HighlighterTest extends TestCase
{
    public function testPlainHighlighter()
    {
        $highlighter = new Highlighter(new PlainStyle());

        $this->assertContains("HighlighterTest", $highlighter->highlight(file_get_contents(__FILE__)));
    }

    public function testHtmlHighlighter()
    {
        $highlighter = new Highlighter(new HtmlStyle(HtmlStyle::DEFAULT));

        $this->assertContains("HighlighterTest", $highlighter->highlight(file_get_contents(__FILE__)));
    }

    public function testInvertedHtmlHighlighter()
    {
        $highlighter = new Highlighter(new HtmlStyle(HtmlStyle::INVERTED));

        $this->assertContains("HighlighterTest", $highlighter->highlight(file_get_contents(__FILE__)));

    }

    public function testConsoleHighlighter()
    {
        $highlighter = new Highlighter(new ConsoleStyle());

        $this->assertContains("HighlighterTest", $highlighter->highlight(file_get_contents(__FILE__)));
    }

    public function testPlainHighlighterLines()
    {
        $highlighter = new Highlighter(new PlainStyle());

        $this->assertContains(
            "HighlighterTest",
            $highlighter->highlightLines(file_get_contents(__FILE__), 17)
        );
    }

    public function testHtmlHighlighterLines()
    {
        $highlighter = new Highlighter(new HtmlStyle(HtmlStyle::DEFAULT));

        $this->assertContains(
            "HighlighterTest",
            $highlighter->highlightLines(file_get_contents(__FILE__), 17)
        );
    }

    public function testInvertedHtmlHighlighterLines()
    {
        $highlighter = new Highlighter(new HtmlStyle(HtmlStyle::INVERTED));

        $this->assertContains(
            "HighlighterTest",
            $highlighter->highlightLines(file_get_contents(__FILE__), 17)
        );

    }

    public function testConsoleHighlighterLines()
    {
        $highlighter = new Highlighter(new ConsoleStyle());

        $this->assertContains(
            "HighlighterTest",
            $highlighter->highlightLines(file_get_contents(__FILE__), 17)
        );
    }

    public function testCountLines()
    {
        $highlighter = new Highlighter(new PlainStyle());

        $this->assertCount(
            1,
            explode("\n", trim($highlighter->highlightLines(file_get_contents(__FILE__), 0, 1), "\n"))
        );

        $this->assertCount(
            2,
            explode("\n", trim($highlighter->highlightLines(file_get_contents(__FILE__), 1, 1), "\n"))
        );

        $this->assertCount(
            3,
            explode("\n", trim($highlighter->highlightLines(file_get_contents(__FILE__), 2, 1), "\n"))
        );
    }
}