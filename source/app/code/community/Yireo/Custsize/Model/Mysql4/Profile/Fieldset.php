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

class Yireo_Custsize_Model_Mysql4_Profile_Fieldset extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('custsize/profile_fieldset', 'fieldset_id');
    }
}
