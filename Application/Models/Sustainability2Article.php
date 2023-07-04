<?php

namespace Fatchip\ClintonSustainability\Application\Models;

use OxidEsales\Eshop\Core\Model\BaseModel;

class Sustainability2Article extends BaseModel
{
    /**
     * @var string
     */
    protected $_sClassName = 'clinton_sustainability2article';

    public function __construct()
    {
        parent::__construct();
        $this->init('clinton_sustainability2article');
    }
}