<?php

namespace Fatchip\ClintonSustainability\Application\Controller\Admin;

use Fatchip\ClintonSustainability\Application\Models\Sustainability;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;

class SustainabilityMain extends AdminDetailsController
{

    public function render()
    {
        parent::render();
        $soxId = $this->_aViewData["oxid"] = $this->getEditObjectId();

        if ($soxId != '-1' && isset($soxId)) {
            $oTest = oxNew(Sustainability::class);
            $oTest->loadInLang($this->_iEditLang, $soxId);
            $this->_aViewData["edit"] = $oTest;
        }

        return "sustainability_main.tpl";
    }

    public function save()
    {
        parent::save();
        $soxId = $this->getEditObjectId();
        $aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("editval");

        $oTest = oxNew(Sustainability::class);

        if ($soxId != '-1') {
            $oTest->loadInLang($this->_iEditLang, $soxId);
        } else {
            $aParams['clinton_sustainability__oxid'] = null;
        }

        if (!isset($aParams['clinton_sustainability__oxactive'])) {
            $aParams['clinton_sustainability__oxactive'] = 0;
        }


        $oTest->assign($aParams);
        $oTest = \OxidEsales\Eshop\Core\Registry::getUtilsFile()->processFiles($oTest);
        $oTest->save();

        // set oxid if inserted
        $this->setEditObjectId($oTest->getId());
    }

}