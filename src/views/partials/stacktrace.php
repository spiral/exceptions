<?php
/**
 * @var Throwable                       $exception
 * @var \Spiral\Exceptions\ValueWrapper $valueWrapper
 * @var \Spiral\Exceptions\Highlighter  $highlighter
 * @var bool                            $showSource
 */
foreach ($stacktrace as $trace) {
    $args = [];
    if (isset($trace['args'])) {
        $args = $valueWrapper->wrap($trace['args']);
    }

    $function = '<strong>' . $trace['function'] . '</strong>';
    if (isset($trace['type']) && isset($trace['class'])) {
        $reflection = new ReflectionClass($trace['class']);
        $function = sprintf(
            '<span title="%s">%s</span>%s%s',
            $reflection->getName(),
            $reflection->getShortName(),
            $trace['type'],
            $function
        );
    }

    if (!isset($trace['file'])) { ?>
        <div class="container no-trace">
            <?= $function ?>(<span class="arguments"><?= join(', ', $args) ?></span>)
        </div>
        <?php
        continue;
    }

    ?>
    <div class="container">
        <div class="location">
            <?= $function ?>(<span class="arguments"><?= join(', ', $args) ?></span>)<br/>
            <em>In&nbsp;<?= $trace['file'] ?>&nbsp;at&nbsp;<strong>line <?= $trace['line'] ?></strong></em>
        </div>
        <?php if ($showSource && file_exists($trace['file'])) : ?>
            <div class="lines">
                <?= $highlighter->highlightLines(file_get_contents($trace['file']), $trace['line']) ?>
            </div>
        <?php endif; ?>
    </div>
<?php }