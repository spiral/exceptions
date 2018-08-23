<div class="environment">
    <?php
    $variables = [
        'GET'     => '_GET',
        'POST'    => '_POST',
        'COOKIES' => '_COOKIE',
        'SESSION' => '_SESSION',
        'SERVER'  => '_SERVER',
    ];

    foreach ($variables as $name => $variable) {
        if (!empty($GLOBALS[$variable])) {
            if ($name == 'SERVER' && isset($_SERVER['PATH']) && is_string($_SERVER['PATH'])) {
                $_SERVER['PATH'] = explode(PATH_SEPARATOR, $_SERVER['PATH']);
            }

            ?>
            <div class="container">
                <div class="title" onclick="toggle('environment-<?= $name ?>')">
                    <?= $name ?> (<?= number_format(count($GLOBALS[$variable])) ?>)
                </div>
                <div class="dump" id="environment-<?= $name ?>" style="display: none;">
                    <?= $dumper->dump($GLOBALS[$variable], \Spiral\Debug\Dumper::RETURN) ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>