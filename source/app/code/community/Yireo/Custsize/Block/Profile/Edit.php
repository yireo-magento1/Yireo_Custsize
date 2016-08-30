<?php
/**
 * Yireo Custsize
 *
 * @author      Yireo (https://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright 2015 Yireo (https://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        https://www.yireo.com/
 */

/**
 * Class Yireo_Custsize_Block_Profile_Edit
 */
class Yireo_Custsize_Block_Profile_Edit extends Yireo_Custsize_Block_Profile_Abstract
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profile/edit.phtml');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if($this->getProfileId() > 0) {
            return $this->__('Edit Size Profile');
        } else {
            return $this->__('New Size Profile');
        }
    }
}
