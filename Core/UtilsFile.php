<?php

namespace Fatchip\ClintonSustainability\Core;

class UtilsFile extends UtilsFile_parent
{
    /**
     * Class constructor, initializes pictures
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->_aTypeToPath['SUSTAINABILITY_IMAGE'] = 'master/product/sustainabilityImages';
    }
}