<?php

namespace Fatchip\ClintonSustainability\Core;

use OxidEsales\Eshop\Core\DbMetaDataHandler;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Events
{
    /**
     * Executes Query to create the clinton_sustainability table in the database
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function createClintonSustainabilityTable()
    {
        $oQueryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $oConnection = $oQueryBuilder->getConnection();
        $oConnection->executeQuery(
            "CREATE TABLE IF NOT EXISTS `clinton_sustainability` (
                `OXID` char(32) COMMENT 'Sustainability ID' NOT NULL,
                `OXACTIVE` tinyint(1) COMMENT 'Sustainability Active' NOT NULL DEFAULT 1,
                `CLITITLE` varchar(255) COMMENT 'Sustainability Title' NOT NULL,
                `CLIIMG` varchar(255) COMMENT 'Sustainability Image' NOT NULL,
                `CLILINK` varchar(255) COMMENT 'Sustainability Link' NOT NULL,
                PRIMARY KEY (OXID)
            ) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
        );
    }

    /**
     * Executes Query to create the clinton_sustainability2article table in the database
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function createClintonSustainabilityToArticleTable()
    {
        $oQueryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $oConnection = $oQueryBuilder->getConnection();
        $oConnection->executeQuery(
            "CREATE TABLE IF NOT EXISTS `clinton_sustainability2article` (
                `OXID` char(32) NOT NULL COMMENT 'Sustainability 2 Article ID',
                `OXARTICLEID` char(32) NOT NULL COMMENT 'Article ID',
                `CLISUSTAINABILITYID` char(32) NOT NULL COMMENT 'Sustainability ID',
                PRIMARY KEY (`OXID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
        );
    }

    /**
     * Updates the views in the database
     *
     * @return void
     */
    public static function rebuildViews()
    {
        if (Registry::getSession()->getVariable('malladmin')) {
            $metaData = oxNew(DbMetaDataHandler::class);
            $metaData->updateViews();
        }
    }

    /**
     * Executed on module activation
     *
     * @return void
     */
    public static function onActivate()
    {
        self::createClintonSustainabilityTable();
        self::createClintonSustainabilityToArticleTable();
        self::rebuildViews();
    }

}