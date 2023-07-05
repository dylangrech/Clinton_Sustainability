<?php

namespace Fatchip\ClintonSustainability\Application\Controller\Admin;

use Fatchip\ClintonSustainability\Application\Models\Sustainability;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Core\Registry;

class SustainabilityMain extends AdminDetailsController
{

    public function render()
    {
        parent::render();
        $soxId = $this->_aViewData["oxid"] = $this->getEditObjectId();

        if ($soxId != '-1' && isset($soxId)) {
            $oSustainability = oxNew(Sustainability::class);
            $oSustainability->loadInLang($this->_iEditLang, $soxId);
            $this->_aViewData["edit"] = $oSustainability;
        }

        return "sustainability_main.tpl";
    }

    public function save()
    {
        parent::save();
        $soxId = $this->getEditObjectId();
        $oRequest = Registry::getRequest();
        $aParams = $oRequest->getRequestEscapedParameter("editval");
        $oSustainability = oxNew(Sustainability::class);

        if ($soxId != '-1') {
            $oSustainability->loadInLang($this->_iEditLang, $soxId);
        } else {
            $aParams['clinton_sustainability__oxid'] = null;
        }

        if (!isset($aParams['clinton_sustainability__oxactive'])) {
            $aParams['clinton_sustainability__oxactive'] = 0;
        }

        $oSustainability->assign($aParams);
        $oSustainability = \OxidEsales\Eshop\Core\Registry::getUtilsFile()->processFiles($oSustainability);
        $oSustainability->save();
        $this->setEditObjectId($oSustainability->getId());
    }

}