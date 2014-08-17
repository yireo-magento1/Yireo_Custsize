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

class Yireo_Custsize_Block_Admin_Profile_Abstract extends Mage_Adminhtml_Block_Widget_Container
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();

        // Set the profile ID and profile
        $this->setProfileId((int)$this->getRequest()->getParam('profile_id', 0));
        $profile = Mage::getModel('custsize/profile')->load($this->getProfileId());
        $this->setProfile($profile);

        // Set the customer ID and customer
        $customer_id = (int)$this->getRequest()->getParam('customer_id', 0);
        if(empty($customer_id)) $customer_id = $profile->getCustomerId();
        $this->setCustomerId($customer_id);
        $customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
        $this->setCustomer($customer);
    }

    /*
     * Get the save URL
     */
    public function getSaveUrl()
    {
        return $this->getUrl('adminhtml/custsize/profile', $this->getUrlParams('save'));
    }

    /*
     * Get the saveascopy URL
     */
    public function getCopyUrl()
    {
        return $this->getUrl('adminhtml/custsize/profile', $this->getUrlParams('copy'));
    }

    /*
     * Get the cofirmdelete URL
     */
    public function getConfirmdeleteUrl()
    {
        return $this->getUrl('adminhtml/custsize/profile', $this->getUrlParams('confirmdelete'));
    }

    /*
     * Get the cofirmdelete URL
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('adminhtml/custsize/profile', $this->getUrlParams('delete'));
    }

    /*
     * Get the cancel URL
     */
    public function getCancelUrl()
    {
        $customerId = (int)$this->getRequest()->getParam('customer_id', 0);
        if($customerId > 0) {
            return $this->getUrl('adminhtml/customer/edit', array('id' => $customerId, 'active_tab' => 'custsize_admin_profiles'));
        } else {
            return $this->getUrl('adminhtml/custsize/profiles');
        }
    }

    /*
     * Get a specific fieldset
     */
    public function getFieldset($fieldset = 'basic')
    {
        $fields = Mage::getModel('custsize/profile_field')->getCollection()
            ->addFieldToFilter('fieldset', $fieldset)
            ->addFieldToFilter('enabled', 1)
            ->setOrder('ordering', 'ASC')
            ->load()
        ;
        return $fields;
    }

    /*
     * Fetch all enabled fieldsets
     */
    public function getFieldsets()
    {
        $collection = Mage::getModel('custsize/profile_fieldset')->getCollection()
            ->addFieldToFilter('enabled', 1)
            ->setOrder('ordering', 'ASC')
            ->load()
        ;
        return $collection;
    }

    /*
     * Get all fields from a specific fieldset
     */
    public function getFieldsFromFieldset($fieldset = 'basic')
    {
        $fields = Mage::getModel('custsize/profile_field')->getCollection()
            ->addFieldToFilter('fieldset', $fieldset)
            ->addFieldToFilter('enabled', 1)
            ->setOrder('ordering', 'ASC')
            ->load()
        ;
        return $fields;
    }

    protected function getUrlParams($task)
    {
        $params = array(
            'task' => $task,
            'profile_id' => $this->getProfileId(),
        );

        $customerId = (int)$this->getRequest()->getParam('customer_id', 0);
        if($customerId > 0) {
            $params['customer_id'] = $customerId;
        }

        return $params;
    }
}
