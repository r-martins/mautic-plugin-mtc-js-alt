<?php

declare(strict_types=1);

return [
    'name'        => 'MtcJsAlternate',
    'description' => 'URL alternativa (outro nome de arquivo) para o script de rastreamento, equivalente a mtc.js.',
    'version'     => '1.0.3',
    'author'      => 'MTC / PB Integrações',
    'services'    => [
        'events'   => [],
        'forms'    => [],
        'helpers'  => [],
    ],
    'parameters' => [
        'alternate_mtc_js_filename' => '',
    ],
];
