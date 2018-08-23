<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Exceptions;

use Spiral\Debug\Dumper;
use Spiral\Debug\Renderer\HtmlRenderer;
use Spiral\Exceptions\Styles\HtmlStyle;

/**
 * Render exception information into html.
 */
class HtmlHandler extends AbstractHandler
{
    /**
     * Visual styles.
     */
    const DEFAULT = "default";
    const INVERTED = "inverted";

    /**
     * @var string
     */
    private $style = self::DEFAULT;

    /**
     * @var Dumper
     */
    private $dumper = null;

    /**
     * @var HtmlRenderer
     */
    protected $renderer = null;

    /**
     * @var Highlighter
     */
    protected $highlighter = null;

    /**
     * @param string $style
     */
    public function __construct(string $style = self::DEFAULT)
    {
        $this->style = $style;
        $this->dumper = new Dumper();

        if ($style == self::INVERTED) {
            $this->renderer = new HtmlRenderer(HtmlRenderer::INVERTED);
            $this->highlighter = new Highlighter(new HtmlStyle(HtmlStyle::INVERTED));
        } else {
            $this->renderer = new HtmlRenderer(HtmlRenderer::DEFAULT);
            $this->highlighter = new Highlighter(new HtmlStyle(HtmlStyle::DEFAULT));
        }

        $this->dumper->setRenderer(Dumper::RETURN, $this->renderer);
    }

    /**
     * @inheritdoc
     */
    public function renderException(\Throwable $e, int $verbosity = self::VERBOSITY_BASIC): string
    {
        $options = [
            'message'      => $this->getMessage($e),
            'exception'    => $e,
            'valueWrapper' => new ValueWrapper($this->dumper, $this->renderer, $verbosity),
            'style'        => $this->render("styles/" . $this->style),
            'footer'       => $this->render("partials/footer"),
            'environment'  => '',
        ];

        $options['stacktrace'] = $this->render('partials/stacktrace', [
            'exception'    => $e,
            'stacktrace'   => $this->getStacktrace($e),
            'dumper'       => $this->dumper,
            'renderer'     => $this->renderer,
            'highlighter'  => $this->highlighter,
            'valueWrapper' => $options['valueWrapper'],
            'showSource'   => $verbosity >= self::VERBOSITY_VERBOSE
        ]);

        $options['chain'] = $this->render('partials/chain', [
            'exception'    => $e,
            'stacktrace'   => $this->getStacktrace($e),
            'valueWrapper' => $options['valueWrapper'],
        ]);

        if ($verbosity >= self::VERBOSITY_DEBUG) {
            $options['environment'] = $this->render('partials/environment', ['dumper' => $this->dumper]);
        }

        return $this->render("exception", $options);
    }

    /**
     * Render PHP template.
     *
     * @param string $view
     * @param array  $options
     * @return string
     */
    private function render(string $view, array $options = []): string
    {
        extract($options, EXTR_OVERWRITE);

        ob_start();
        require $this->getFilename($view);
        return ob_get_clean();
    }

    /**
     * Get view filename.
     *
     * @param string $view
     * @return string
     */
    private function getFilename(string $view): string
    {
        return sprintf("%s/views/%s.php", basename(__DIR__), $view);
    }
}