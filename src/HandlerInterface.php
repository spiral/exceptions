<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Exceptions;

/**
 * HandlerInterface is responsible for an exception explanation.
 */
interface HandlerInterface
{
    /**
     * Verbosity levels for stack trace.
     */
    const VERBOSITY_BASIC = 0;
    const VERBOSITY_VERBOSE = 1;
    const VERBOSITY_DEBUG = 2;

    /**
     * Method must return prepared exception message.
     *
     * @param \Throwable $e
     * @return string
     */
    public function getMessage(\Throwable $e): string;

    /**
     * Render exception debug information into stream.
     *
     * @param \Throwable $e
     * @param int        $verbosity
     * @return string
     */
    public function renderException(\Throwable $e, int $verbosity = self::VERBOSITY_VERBOSE): string;
}