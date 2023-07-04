<?php

namespace Fatchip\ClintonSustainability\Application\Controller\Admin;

use Exception;
use Fatchip\ClintonSustainability\Application\Models\Sustainability2Article;
use OxidEsales\Eshop\Application\Controller\Admin\ListComponentAjax;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

class ArticleSustainabilityAjax extends ListComponentAjax
{
    /**
     * All required columns for the assign popup
     *
     * @var array
     */
    protected $_aColumns =
        [
            'container1' =>
                [
                    ['clititle', 'clinton_sustainability', 1, 1, 0],
                    ['oxid', 'clinton_sustainability', 0, 0, 1],
                ],
            'container2' =>
                [
                    ['clititle', 'clinton_sustainability', 1, 0, 0],
                    ['oxid', 'clinton_sustainability', 0, 0, 1],
                    ['oxid', 'clinton_sustainability2article', 0, 0, 1]
                ],
        ];

    /**
     * Returns an SQL query for data to be fetched
     *
     * @return string
     * @throws DatabaseConnectionException
     */
    protected function _getQuery() // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
    {
        $oRequest = Registry::getRequest();
        $oTableViewNameGenerator = oxNew(TableViewNameGenerator::class);

        $sClintonSustainabilityTable = $oTableViewNameGenerator->getViewName('clinton_sustainability', $oRequest->getRequestEscapedParameter('editlanguage'));
        $sClintonSustainability2ArticleTable = $oTableViewNameGenerator->getViewName('clinton_sustainability2article', $oRequest->getRequestEscapedParameter('editlanguage'));
        $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $sOxid = $oRequest->getRequestEscapedParameter('oxid');
        $sSynchOxid = $oRequest->getRequestEscapedParameter('synchoxid');

        if ($sOxid) {
            $sQueryAdd = "from $sClintonSustainabilityTable JOIN  $sClintonSustainability2ArticleTable ON $sClintonSustainabilityTable.OXID = $sClintonSustainability2ArticleTable.CLISUSTAINABILITYID WHERE $sClintonSustainability2ArticleTable.OXARTICLEID = ". $oDb->quote($sOxid);
        } else {
            $sQueryAdd = " from $sClintonSustainabilityTable where $sClintonSustainabilityTable.oxid not in ( select $sClintonSustainability2ArticleTable.clisustainabilityid from $sClintonSustainability2ArticleTable left join $sClintonSustainabilityTable on $sClintonSustainabilityTable.oxid = $sClintonSustainability2ArticleTable.clisustainabilityid where $sClintonSustainability2ArticleTable.oxarticleid = ".$oDb->quote($sSynchOxid)." and $sClintonSustainabilityTable.oxid is not null)";
        }

        return $sQueryAdd;
    }

    /**
     * Removes Sustainability Licence from Article
     *
     * @throws DatabaseConnectionException|DatabaseErrorException
     */
    public function fcRemoveSustainabilityFromArticle()
    {
        $oRequest = Registry::getRequest();
        $aRemoveSustainability = $this->_getActionIds('clinton_sustainability2article.oxid');

        if ($oRequest->getRequestEscapedParameter('all')) {
            $sQuery = $this->_addFilter("delete clinton_sustainability2article.* " . $this->_getQuery());
            \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->Execute($sQuery);
        } elseif ($aRemoveSustainability && is_array($aRemoveSustainability)) {
            $sQuery = "DELETE FROM clinton_sustainability2article WHERE clinton_sustainability2article.oxid IN (" . implode(", ", \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->quoteArray($aRemoveSustainability)) . ") ";
            \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->Execute($sQuery);
        }
    }

    /**
     * Adds Sustainability Licence to Article
     * @throws Exception
     */
    public function fcAddSustainabilityToArticle()
    {
        $oRequest = Registry::getRequest();
        $oTableViewNameGenerator = oxNew(TableViewNameGenerator::class);
        $aAddSustainabilityLicences = $this->_getActionIds('clinton_sustainability.oxid');
        $sSynchOxid = $oRequest->getRequestEscapedParameter('synchoxid');

        if ($oRequest->getRequestEscapedParameter('all')) {
            $sClintonSustainabilityTable = $oTableViewNameGenerator->getViewName('clinton_sustainability', $oRequest->getRequestEscapedParameter('editlanguage'));
            $aAddSustainabilityLicences = $this->_getAll($this->_addFilter("select $sClintonSustainabilityTable.oxid " . $this->_getQuery()));
        }
        if ($sSynchOxid && $sSynchOxid != "-1" && is_array($aAddSustainabilityLicences)) {
            foreach ($aAddSustainabilityLicences as $aAddSustainabilityLicence) {
                $oSustainability2Article = oxNew(Sustainability2Article::class);
                $oSustainability2Article->clinton_sustainability2article__clisustainabilityid = new \OxidEsales\Eshop\Core\Field($aAddSustainabilityLicence);
                $oSustainability2Article->clinton_sustainability2article__oxarticleid = new \OxidEsales\Eshop\Core\Field($sSynchOxid);
                $oSustainability2Article->save();
            }
        }
    }
}