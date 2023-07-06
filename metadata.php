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
        'sustainability'            => Fatchip\ClintonSustainability\Application\Controller\Admin\SustainabilityController::class,
        'sustainability_list'       => Fatchip\ClintonSustainability\Application\Controller\Admin\SustainabilityList::class,
        'sustainability_main'       => Fatchip\ClintonSustainability\Application\Controller\Admin\SustainabilityMain::class,
        'article_extend_popup_ajax' => Fatchip\ClintonSustainability\Application\Controller\Admin\ArticleSustainabilityAjax::class,
    ],
    'templates' => [
        'sustainability.tpl'        => 'fc/clisustainability/Application/views/admin/tpl/sustainability.tpl',
        'sustainability_list.tpl'   => 'fc/clisustainability/Application/views/admin/tpl/sustainability_list.tpl',
        'sustainability_main.tpl'   => 'fc/clisustainability/Application/views/admin/tpl/sustainability_main.tpl',
        'article_extend_popup.tpl'  => 'fc/clisustainability/Application/views/admin/tpl/article_extend_popup.tpl',
    ],
    'extend'      => [
        \OxidEsales\Eshop\Core\UtilsFile::class                                 => \Fatchip\ClintonSustainability\Core\UtilsFile::class,
        \OxidEsales\Eshop\Application\Controller\Admin\ArticleExtend::class     => \Fatchip\ClintonSustainability\Application\Controller\Admin\ArticleExtend::class,
        \OxidEsales\Eshop\Application\Component\Widget\ArticleDetails::class    => \Fatchip\ClintonSustainability\Application\Component\Widget\ArticleDetails::class,
    ],
    'blocks'      => [
        ['template' => 'article_extend.tpl',        'block' => 'admin_article_extend_media',    'file' => 'Application/blocks/admin/article_extend.tpl'],
        ['template' => 'page/details/inc/tabs.tpl', 'block' => 'details_tabs_longdescription',  'file' => 'Application/blocks/tabs.tpl']
    ],
    'events'       => [
        'onActivate' => '\Fatchip\ClintonSustainability\Core\Events::onActivate'
    ],
    'settings'     => []
];

