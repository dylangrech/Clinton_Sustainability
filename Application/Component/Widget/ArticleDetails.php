<?php

namespace Fatchip\ClintonSustainability\Application\Component\Widget;

use OxidEsales\Eshop\Core\ViewConfig;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class ArticleDetails extends ArticleDetails_parent
{
    public function fcGetSustainabilityTitle($aSustainabilityData)
    {
        return $aSustainabilityData['Title'];
    }

    public function fcGetSustainabilityImageUrl($aSustainabilityData)
    {
        $oViewConfig = oxNew(ViewConfig::class);
        $sBaseUrl = $oViewConfig->getBaseDir();
        return $sBaseUrl. '/out/pictures/master/product/sustainabilityImages/'.$aSustainabilityData['Image Name'];
    }

    public function fcGetSustainabilityLink($aSustainabilityData)
    {
        return $aSustainabilityData['Link'];
    }

    public function fcGetSustainabilityDataById($oArticle)
    {
        $aSustainabilityData = [];
        $aSustainabilityIds = $this->fcGetRelatedSustainabilityIds($oArticle);
        if ($aSustainabilityIds === false) {
            return false;
        }
        foreach ($aSustainabilityIds as $sSustainabilityId) {
            $sQuery = "SELECT oxactive, clititle, cliimg, clilink FROM clinton_sustainability WHERE oxid = '".$sSustainabilityId."'";
            $aRows = $this->fcExecuteQueryAndReturnResult($sQuery);
            foreach ($aRows as $aRow) {
                if ($aRow['oxactive'] === '0') {
                    continue;
                }
                $aSustainabilityData[] = ['Title' => $aRow['clititle'], 'Image Name' => $aRow['cliimg'], 'Link' => $aRow['clilink'],];
            }
        }
        return $aSustainabilityData;
    }

    public function fcGetRelatedSustainabilityIds($oArticle) {
        $aSustainabilityIds = [];
        $sArticleId = $oArticle->oxarticles__oxid->value;
        $sQuery = "SELECT clisustainabilityid FROM clinton_sustainability2article WHERE oxarticleid = '".$sArticleId."'";
        $aRows = $this->fcExecuteQueryAndReturnResult($sQuery);
        foreach ($aRows as $aRow) {
            $aSustainabilityIds[] = $aRow['clisustainabilityid'];
        }
        if (empty($aSustainabilityIds)) {
            return false;
        }
        return $aSustainabilityIds;
    }

    public function fcExecuteQueryAndReturnResult($sQuery)
    {
        $oQueryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $oConnection = $oQueryBuilder->getConnection();
        $aResult = $oConnection->executeQuery($sQuery);
        return $aResult->fetchAll();
    }
}