<?php

namespace Fatchip\ClintonSustainability\Application\Controller\Admin;

use oxRegistry;
use oxDb;
use oxField;
use stdClass;
use Exception;

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
        parent::render();

        $this->_aViewData['edit'] = $article = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);

        $oxId = $this->getEditObjectId();

        $this->_createCategoryTree("artcattree");

        // all categories
        if (isset($oxId) && $oxId != "-1") {
            // load object
            $article->loadInLang($this->_iEditLang, $oxId);

            $article = $this->updateArticle($article);

            // load object in other languages
            $otherLang = $article->getAvailableInLangs();
            if (!isset($otherLang[$this->_iEditLang])) {
                $article->loadInLang(key($otherLang), $oxId);
            }

            foreach ($otherLang as $id => $language) {
                $lang = new stdClass();
                $lang->sLangDesc = $language;
                $lang->selected = ($id == $this->_iEditLang);
                $this->_aViewData["otherlang"][$id] = clone $lang;
            }

            // variant handling
            if ($article->oxarticles__oxparentid->value) {
                $parentArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
                $parentArticle->load($article->oxarticles__oxparentid->value);
                $this->_aViewData["parentarticle"] = $parentArticle;
                $this->_aViewData["oxparentid"] = $article->oxarticles__oxparentid->value;
            }
        }

        $this->prepareBundledArticlesDataForView($article);

        $iAoc = $this->getConfig()->getRequestParameter("aoc");
        if ($iAoc == 1) {
            $oArticleExtendAjax = oxNew(\OxidEsales\Eshop\Application\Controller\Admin\ArticleExtendAjax::class);
            $this->_aViewData['oxajax'] = $oArticleExtendAjax->getColumns();

            return "popups/article_extend.tpl";
        } elseif ($iAoc == 2) {
            $oArticleBundleAjax = oxNew(\OxidEsales\Eshop\Application\Controller\Admin\ArticleBundleAjax::class);
            $this->_aViewData['oxajax'] = $oArticleBundleAjax->getColumns();

            return "popups/article_bundle.tpl";
        } elseif ($iAoc == 3) {
            $oArticleBundleAjax = oxNew(\Fatchip\ClintonSustainability\Application\Controller\Admin\ArticleSustainabilityAjax::class);
            $this->_aViewData['oxajax'] = $oArticleBundleAjax->getColumns();
            return "article_extend_popup.tpl";
        }

        //load media files
        $this->_aViewData['aMediaUrls'] = $article->getMediaUrls();

        return "article_extend.tpl";
    }
}