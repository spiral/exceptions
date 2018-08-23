<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Exceptions\Styles;

use Spiral\Exceptions\StyleInterface;

/**
 * Similar to ConsoleRenderer but without colorization.
 */
class PlainStyle implements StyleInterface
{
    /**
     * @inheritdoc
     */
    public function token(array $token, array $previous): string
    {
        return $token[1];
    }

    /**
     * @inheritdoc
     */
    public function line(int $number, string $code, bool $target = false): string
    {
        if ($target) {
            return sprintf(">%s %s\n", str_pad($number, 4, " ", STR_PAD_LEFT), $code);
        }

        return sprintf(" %s %s\n", str_pad($number, 4, " ", STR_PAD_LEFT), $code);
    }
}