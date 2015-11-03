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

class Yireo_Custsize_Block_Profile_Abstract extends Mage_Core_Block_Template
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();

        // Set the profile ID
        $this->setProfileId((int)$this->getRequest()->getParam('profile_id', 0));

        // Set the profile
        $profile = Mage::getModel('custsize/profile')->load($this->getProfileId());
        $customer = Mage::getModel('customer/session')->getCustomer();

        $allProfiles = Mage::getModel('custsize/profile')->getCollection()->addFieldToFilter('customer_id', $customer->getId());
        if($allProfiles->count() == 0) {
            $profile->setData('default', 1);
            $profile->setData('name', $customer->getName());
            $profile->setData('description', $this->__('My default profile'));
        }

        $customerSession = Mage::getSingleton('customer/session');
        $fieldData = $customerSession->getData('custsize_tmp_fields');
        $profileData = $customerSession->getData('custsize_tmp_profile');

        if (!empty($profileData)) {
            foreach($profileData as $profileName => $profileValue) {
                $profile->setData($profileName, $profileValue);
            }
        }

        if (!empty($fieldData)) {
            foreach($fieldData as $fieldId => $fieldValue) {
                $profile->setData('field'.$fieldId, $fieldValue);
            }
        }

        $customerSession->setData('custsize_tmp_fields', null);
        $customerSession->setData('custsize_tmp_profile', null);

        $this->setProfile($profile);
    }

    /**
     * Get the save URL
     */
    public function getSaveUrl()
    {
        return $this->getUrl('custsize/index/profile', array('task' => 'save', 'profile_id' => $this->getProfileId()));
    }

    /**
     * Get the cofirm-delete URL
     */
    public function getConfirmdeleteUrl()
    {
        return $this->getUrl('custsize/index/profile', array('task' => 'confirmdelete', 'profile_id' => $this->getProfileId()));
    }

    /**
     * Get the delete URL
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('custsize/index/profile', array('task' => 'delete', 'profile_id' => $this->getProfileId()));
    }

    /**
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

    /**
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
}
