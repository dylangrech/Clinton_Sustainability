<?php

namespace Fatchip\ClintonSustainability\Model;

class Sustainability extends \OxidEsales\Eshop\Core\Model\MultiLanguageModel
{
    /**
     * Name of current class
     *
     * @var string
     */
    protected $_sClassName = 'sustainability';

    /**
     * Class constructor, initiates parent constructor (parent::oxBase()).
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('clinton_sustainability');
    }
}