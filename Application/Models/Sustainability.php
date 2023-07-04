<?php

namespace Fatchip\ClintonSustainability\Application\Models;

use OxidEsales\Eshop\Core\Model\MultiLanguageModel;

class Sustainability extends MultiLanguageModel
{
    /**
     * @var string
     */
    protected $_sClassName = 'clinton_sustainability';

    public function __construct()
    {
        parent::__construct();
        $this->init('clinton_sustainability');
    }

    /**
     * Returns the image url
     *
     * @return string|void
     */
    public function fcGetImageUrl()
    {
        $sUploadedLicenceImage = $this->clinton_sustainability__cliimg->value;
        if ($sUploadedLicenceImage !== false) {
            $sBaseURL = (new \OxidEsales\Eshop\Core\ViewConfig)->getBaseDir();
            return $sBaseURL.'/out/pictures/master/product/sustainabilityImages/'.$sUploadedLicenceImage;
        }
        return false;
    }

    /**
     * Get the value of the Image Name column according to the table selected.
     * Returns false if the column is empty.
     * Returns a string value if the column is not empty.
     * @param $dbImageNameColumn
     * @return false|string
     */
    public function fcGetPromotionPlannerImageName($dbImageNameColumn)
    {
        $sPromotionImage = $dbImageNameColumn->value;
        if ($sPromotionImage !== '') {
            return $sPromotionImage;
        }
        return false;
    }
}