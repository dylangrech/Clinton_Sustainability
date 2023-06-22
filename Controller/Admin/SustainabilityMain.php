<?php

namespace Fatchip\ClintonSustainability\Controller\Admin;

use Fatchip\ClintonSustainability\Model\Sustainability;

class SustainabilityMain extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * Executes parent method parent::render(), creates oxgroups object,
     * passes data to Smarty engine and returns name of template file
     * "usergroup_main.tpl".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $soxId = $this->_aViewData["oxid"] = $this->getEditObjectId();
        if (isset($soxId) && $soxId != "-1") {
            // load object
                $oGroup = oxNew(Sustainability::class);
            $oGroup->loadInLang($this->_iEditLang, $soxId);

            $oOtherLang = $oGroup->getAvailableInLangs();
            if (!isset($oOtherLang[$this->_iEditLang])) {
                // echo "language entry doesn't exist! using: ".key($oOtherLang);
                $oGroup->loadInLang(key($oOtherLang), $soxId);
            }

            $this->_aViewData["edit"] = $oGroup;

            // remove already created languages
            $aLang = array_diff(\OxidEsales\Eshop\Core\Registry::getLang()->getLanguageNames(), $oOtherLang);

            if (count($aLang)) {
                $this->_aViewData["posslang"] = $aLang;
            }

            foreach ($oOtherLang as $id => $language) {
                $oLang = new stdClass();
                $oLang->sLangDesc = $language;
                $oLang->selected = ($id == $this->_iEditLang);
                $this->_aViewData["otherlang"][$id] = clone $oLang;
            }
        }
        //if (\OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("aoc")) {
        //    $oUsergroupMainAjax = oxNew(\OxidEsales\Eshop\Application\Controller\Admin\UserGroupMainAjax::class);
        //    $this->_aViewData['oxajax'] = $oUsergroupMainAjax->getColumns();

        //    return "popups/usergroup_main.tpl";
        //}

        return "usergroup_main.tpl";
    }

    /**
     * Saves changed usergroup parameters.
     */
    public function save()
    {
        parent::save();

        $soxId = $this->getEditObjectId();
        $aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("editval");
        // checkbox handling
        if (!isset($aParams['clinton_sustainability__oxactive'])) {
            $aParams['clinton_sustainability__oxactive'] = 0;
        }

        $oGroup = oxNew(Sustainability::class);
        if ($soxId != "-1") {
            $oGroup->load($soxId);
        } else {
            $aParams['clinton_sustainability__oxid'] = null;
        }

        $oGroup->setLanguage(0);
        $oGroup->assign($aParams);
        $oGroup->setLanguage($this->_iEditLang);
        $oGroup->save();

        // set oxid if inserted
        $this->setEditObjectId($oGroup->getId());
    }

    /**
     * Saves changed selected group parameters in different language.
     */
    public function saveinnlang()
    {
        $this->save();
    }
}