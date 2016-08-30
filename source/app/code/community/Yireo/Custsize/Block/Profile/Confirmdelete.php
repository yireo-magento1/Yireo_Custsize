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
 * Class Yireo_Custsize_Block_Profile_Confirmdelete
 */
class Yireo_Custsize_Block_Profile_Confirmdelete extends Yireo_Custsize_Block_Profile_Abstract
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profile/confirmdelete.phtml');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->__('Delete Size Profile');
    }
}
