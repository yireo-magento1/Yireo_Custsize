<?php
/**
 * Yireo Custsize
 *
 * @author      Yireo (http://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright 2015 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        http://www.yireo.com/
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
     *
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
