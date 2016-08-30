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
 * Class Yireo_Custsize_Model_Profile_Field
 */
class Yireo_Custsize_Model_Profile_Field extends Mage_Core_Model_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('custsize/profile_field');
    }
}
