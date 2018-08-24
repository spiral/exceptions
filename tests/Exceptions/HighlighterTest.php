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
use Spiral\Exceptions\Styles\ConsoleStyle;
use Spiral\Exceptions\Styles\HtmlStyle;
use Spiral\Exceptions\Styles\PlainStyle;

class HighlighterTest extends TestCase
{
    public function testPlainHighlighter()
    {
        $highlighter = new Highlighter(new PlainStyle());
        $result = $highlighter->highlight(file_get_contents(__FILE__));

        $this->assertContains("HighlighterTest", $result);
    }

    public function testHtmlHighlighter()
    {
        $highlighter = new Highlighter(new HtmlStyle(HtmlStyle::DEFAULT));
        $result = $highlighter->highlight(file_get_contents(__FILE__));

        $this->assertContains("HighlighterTest", $result);
    }

    public function testInvertedHtmlHighlighter()
    {
        $highlighter = new Highlighter(new HtmlStyle(HtmlStyle::INVERTED));
        $result = $highlighter->highlight(file_get_contents(__FILE__));

        $this->assertContains("HighlighterTest", $result);
    }

    public function testConsoleHighlighter()
    {
        $highlighter = new Highlighter(new ConsoleStyle());
        $result = $highlighter->highlight(file_get_contents(__FILE__));

        $this->assertContains("HighlighterTest", $result);
    }
}