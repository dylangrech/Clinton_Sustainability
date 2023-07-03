<?php

namespace Fatchip\ClintonSustainability\Application\Controller\Admin;

class ArticleSustainabilityAjax extends \OxidEsales\Eshop\Application\Controller\Admin\ListComponentAjax
{
    /**
     * Columns array
     *
     * @var array
     */
    protected $_aColumns = [
        'container1' => [ // field , table, visible, multilanguage, ident
            ['clititle', 'clinton_sustainability', 1, 1, 0],
            ['oxid', 'clinton_sustainability', 0, 0, 1]
        ],
        'container2' => [
            ['clititle', 'clinton_sustainability', 1, 1, 0],
            ['oxid', 'clinton_sustainability', 0, 0, 0],
            ['oxid', 'clinton_sustainability2article', 0, 0, 1],
            ['oxid', 'clinton_sustainability', 0, 0, 1]
        ],
    ];

    /**
     * Returns SQL query for data to fetc
     *
     * @return string
     * @deprecated underscore prefix violates PSR12, will be renamed to "getQuery" in next major
     */
    protected function _getQuery() // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
    {
        $categoriesTable = $this->_getViewName('clinton_sustainability');
        $objectToCategoryView = $this->_getViewName('clinton_sustainability2article');
        $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();

        $oxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        $synchOxid = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('synchoxid');

        if ($oxId) {
            $query = "SELECT oxarticleid FROM clinton_sustainability2article";
            // all categories article is in
            //$query = " from $objectToCategoryView left join $categoriesTable on $categoriesTable.oxid=$objectToCategoryView.clisustainabilityid ";
            //$query .= " where $objectToCategoryView.oxarticleid = " . $database->quote($oxId)
            //    . " and $categoriesTable.oxid is not null ";
        } else {
            $query = "SELECT oxid FROM clinton_sustainability";
            //$query = " from $categoriesTable where $categoriesTable.oxid not in ( ";
            //$query .= " select $categoriesTable.oxid from $objectToCategoryView "
            //    . "left join $categoriesTable on $categoriesTable.oxid=$objectToCategoryView.oxcatnid ";
            //$query .= " where $objectToCategoryView.oxobjectid = " . $database->quote($synchOxid)
           //     . " and $categoriesTable.oxid is not null ) and $categoriesTable.oxpriceto = '0'";
        }

        return $query;
    }

    /**
     * Adds article to chosen category
     *
     * @throws Exception
     */
    public function addCat()
    {
        $config = $this->getConfig();
        $categoriesToAdd = $this->_getActionIds('oxcategories.oxid');
        $oxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('synchoxid');
        $shopId = $config->getShopId();
        $objectToCategoryView = $this->_getViewName('oxobject2category');

        // adding
        if (\OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('all')) {
            $categoriesTable = $this->_getViewName('oxcategories');
            $categoriesToAdd = $this->_getAll($this->_addFilter("select $categoriesTable.oxid " . $this->_getQuery()));
        }

        if (isset($categoriesToAdd) && is_array($categoriesToAdd)) {
            // We force reading from master to prevent issues with slow replications or open transactions (see ESDEV-3804 and ESDEV-3822).
            $database = \OxidEsales\Eshop\Core\DatabaseProvider::getMaster();

            $objectToCategory = oxNew(\OxidEsales\Eshop\Application\Model\Object2Category::class);

            foreach ($categoriesToAdd as $sAdd) {
                // check, if it's already in, then don't add it again
                $sSelect = "select 1 from " . $objectToCategoryView . " as oxobject2category " .
                    "where oxobject2category.oxcatnid = :oxcatnid " .
                    "and oxobject2category.oxobjectid = :oxobjectid";
                if ($database->getOne($sSelect, [':oxcatnid' => $sAdd, ':oxobjectid' => $oxId])) {
                    continue;
                }

                $objectToCategory->setId(md5($oxId . $sAdd . $shopId));
                $objectToCategory->oxobject2category__oxobjectid = new \OxidEsales\Eshop\Core\Field($oxId);
                $objectToCategory->oxobject2category__oxcatnid = new \OxidEsales\Eshop\Core\Field($sAdd);
                $objectToCategory->oxobject2category__oxtime = new \OxidEsales\Eshop\Core\Field(time());

                $objectToCategory->save();
            }

            $this->_updateOxTime($oxId);

            $this->resetArtSeoUrl($oxId);
            $this->resetContentCache();
            $this->onCategoriesAdd($categoriesToAdd);
        }
    }
}