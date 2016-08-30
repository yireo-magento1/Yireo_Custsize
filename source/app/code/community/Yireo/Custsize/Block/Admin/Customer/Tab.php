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
 * Class Yireo_Custsize_Block_Admin_Customer_Tab
 */
class Yireo_Custsize_Block_Admin_Customer_Tab extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * @var Mage_Customer_Model_Customer
     */
    protected $currentCustomer;

    /**
     * @var Mage_Customer_Helper_Data
     */
    protected $helper;

    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profiles_tab.phtml');
        $this->currentCustomer = Mage::registry('current_customer');
        $this->helper = Mage::helper('customer');
    }

    /**
     * @return string
     */
    public function getTabLabel()
    {
        return $this->helper->__('Customer Size Profiles');
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->helper->__('Customer Size Profiles');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        if ($this->currentCustomer->getId()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        if ($this->currentCustomer->getId()) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getAfter()
    {
        return 'tags';
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()
            ->createBlock('custsize/admin_profiles_grid', 'profiles.grid')
            ->setSaveParametersInSession(true)
        );
        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
