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

class Yireo_Custsize_Block_Admin_Customer_Tab  extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profiles_tab.phtml');
    }

    public function getTabLabel()
    {
        return Mage::helper('customer')->__('Customer Size Profiles');
    }

    public function getTabTitle()
    {
        return Mage::helper('customer')->__('Customer Size Profiles');
    }

    public function canShowTab()
    {
        if(Mage::registry('current_customer')->getId()) {
            return true;
        }
        return false;
    }

    public function isHidden()
    {
        if(Mage::registry('current_customer')->getId()) {
            return false;
        }
        return true;
    }

    public function getAfter()
    {
        return 'tags';
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()
            ->createBlock('custsize/admin_profiles_grid', 'profiles.grid')
            ->setSaveParametersInSession(true)
        );
        return parent::_prepareLayout();
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
