<?php

namespace Fatchip\ClintonSustainability\Application\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;

class ArticleExtend extends ArticleExtend_parent
{
    /**
     * Collects available article extended parameters, passes them to
     * Smarty engine and returns template file name "article_extend.tpl".
     *
     * @return string
     */
    public function render()
    {
        $sTemplate = parent::render();

        $oRequest = Registry::getRequest();
        $iAoc = $oRequest->getRequestEscapedParameter("aoc");
        if ($iAoc == 3) {
            $oArticleSustainabilityAjax = oxNew(ArticleSustainabilityAjax::class);
            $this->_aViewData['oxajax'] = $oArticleSustainabilityAjax->getColumns();
            $sTemplate = "article_extend_popup.tpl";
        }

        return $sTemplate;
    }
}