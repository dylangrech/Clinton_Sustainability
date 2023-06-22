<?php

namespace Fatchip\ClintonSustainability\Core;

use OxidEsales\Eshop\Core\DbMetaDataHandler;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class Events
{

    public static function createClintonSustainabilityTable()
    {
        $oQueryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $oConnection = $oQueryBuilder->getConnection();
        $oConnection->executeQuery("CREATE TABLE IF NOT EXISTS `clinton_sustainability` (
  `OXID` char(32) COMMENT 'Sustainability ID' NOT NULL,
  `OXACTIVE` tinyint(1) COMMENT 'Sustainability Active' NOT NULL DEFAULT 0,
  `CLITITLE` varchar(255) COMMENT 'Sustainability Title' NOT NULL,
  `CLIIMG` varchar(255) COMMENT 'Sustainability Image' NOT NULL,
  `CLILINK` varchar(255) COMMENT 'Sustainability Link' NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
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
        self::rebuildViews();
    }

}