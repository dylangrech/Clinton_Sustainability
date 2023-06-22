<?php

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = [
    'id'          => 'clisustainability',
    'title'       => [
        'de' => 'Clinton Nachhaltigkeit',
        'en' => 'Clinton Sustainability',
    ],
    'description' => [
        'de' => '',
        'en' => '',
    ],
    'thumbnail'   => '',
    'version'     => '1.0',
    'author'      => 'Dylan Grech',
    'url'         => 'https://www.oxid-esales.com/',
    'email'       => 'dylangrech99@gmail.com',
    'controllers' => [
        'clinton_sustainability_admin' => \Fatchip\ClintonSustainability\Controller\Admin\SustainabilityController::class,
        'clinton_sustainability_list' => \Fatchip\ClintonSustainability\Controller\Admin\SustainabilityListController::class,
        'clinton_sustainability_main' => \Fatchip\ClintonSustainability\Controller\Admin\SustainabilityMain::class,
        'clinton_sustainability' => \Fatchip\ClintonSustainability\Model\Sustainability::class,
    ],
    'templates' => [
        'fc_cli_sustainability.tpl' => 'fc/clisustainability/views/admin/tpl/fc_cli_sustainability.tpl',
        'fc_cli_sustainability_list.tpl' => 'fc/clisustainability/views/admin/tpl/fc_cli_sustainability_list.tpl',
        'fc_cli_sustainability_main.tpl' => 'fc/clisustainability/views/admin/tpl/fc_cli_sustainability_main.tpl',
    ],
    'extend'      => [],
    'blocks'      => [],
    'events'       => [
        'onActivate' => '\Fatchip\ClintonSustainability\Core\Events::onActivate'
    ],
    'settings'     => []
];
