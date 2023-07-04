<?php

namespace Fatchip\ClintonSustainability\Application\Controller\Admin;

use Fatchip\ClintonSustainability\Application\Models\Sustainability;
use OxidEsales\Eshop\Application\Controller\Admin\AdminListController;

class SustainabilityList extends AdminListController
{
    /**
     * Name of chosen object class
     *
     * @var string
     */
    protected $_sListClass = 'sustainability_list';

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = "sustainability_list.tpl";

    /**
     * Executes parent method parent::render() and returns current class template
     * name.
     *
     * @return string
     */
    public function render()
    {
        parent::render();
        return $this->_sThisTemplate;
    }

    /**
     * Deletes Entry
     *
     * @return void|null
     */
    public function deleteEntry()
    {
        $oSustainability = oxNew(Sustainability::class);
        if ($oSustainability->isDerived()) {
            return;
        }
        $blDelete = $oSustainability->delete($this->getEditObjectId());
        if ($blDelete && isset($_POST['oxid'])) {
            $_POST['oxid'] = -1;
        }
        $this->resetContentCache();
        $this->init();
    }


    public function getItemList()
    {
        if ($this->_oList === null && $this->_sListClass) {
            $this->_oList = oxNew($this->_sListType);
            $this->_oList->clear();
            if ($this->_sListClass === 'sustainability_list') {
                $this->_oList->init(Sustainability::class);
            } else {
                $this->_oList->init($this->_sListClass);
            }


            $where = $this->buildWhere();

            $listObject = $this->_oList->getBaseObject();

            \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('tabelle', $this->_sListClass);
            $this->_aViewData['listTable'] = getViewName($listObject->getCoreTableName());
            $this->getConfig()->setGlobalParameter('ListCoreTable', $listObject->getCoreTableName());

            if ($listObject->isMultilang()) {
                // is the object multilingual?
                /** @var \OxidEsales\Eshop\Core\Model\MultiLanguageModel $listObject */
                $listObject->setLanguage(\OxidEsales\Eshop\Core\Registry::getLang()->getBaseLanguage());

                if (isset($this->_blEmployMultilanguage)) {
                    $listObject->setEnableMultilang($this->_blEmployMultilanguage);
                }
            }

            $query = $this->_buildSelectString($listObject);
            $query = $this->_prepareWhereQuery($where, $query);
            $query = $this->_prepareOrderByQuery($query);
            $query = $this->_changeselect($query);

            // calculates count of list items
            $this->_calcListItemsCount($query);

            // setting current list position (page)
            $this->_setCurrentListPosition(\OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('jumppage'));

            // setting addition params for list: current list size
            $this->_oList->setSqlLimit($this->_iCurrListPos, $this->_getViewListSize());

            $this->_oList->selectString($query);
        }

        return $this->_oList;
    }
}