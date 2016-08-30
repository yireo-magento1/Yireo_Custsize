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
 * Class Yireo_Custsize_Block_Product_Select
 */
class Yireo_Custsize_Block_Product_Select extends Mage_Core_Block_Template
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
    }

    /**
     * @return bool
     */
    public function customerIsLoggedIn()
    {
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if($customerId > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return Mage_Catalog_Model_Product|mixed
     */
    public function getProduct()
    {
        return Mage::registry('product');
    }

    /**
     * @return null
     */
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

    /**
     * @return string
     */
    public function getNewProfileUrl()
    {
        return $this->getUrl('custsize/index/profile', array('task' => 'new'));
    }
}
