<?php
/**
 * Yireo Custsize
 *
 * @author      Yireo (http://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright (C) 2014 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        http://www.yireo.com/
 */

class Yireo_Custsize_Block_Product_Select extends Mage_Core_Block_Template
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
    }

    public function customerIsLoggedIn()
    {
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if($customerId > 0) {
            return true;
        }

        return false;
    }

    public function getProduct()
    {
        return Mage::registry('product');
    }

    public function getProfiles()
    {
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if(!$customerId > 0) {
            return null;
        }

        static $profiles = null;
        if(empty($profiles)) {
            $profiles = Mage::getModel('custsize/profile')->getCollection()->addFieldToFilter('customer_id', $customerId);
        }
        return $profiles;
    }

    public function getNewProfileUrl()
    {
        return $this->getUrl('custsize/index/profile', array('task' => 'new'));
    }
}
