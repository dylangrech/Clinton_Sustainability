<?php

namespace Fatchip\ClintonSustainability\Controller\Admin;

class SustainabilityListController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminListController
{
    /**
     * Name of chosen object class (default null).
     *
     * @var string
     */
    protected $_sListClass = 'sustainability';

    /**
     * Executes parent method parent::render() and returns name of template
     * file "usergroup_list.tpl".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        return "usergroup_list.tpl";
    }
}