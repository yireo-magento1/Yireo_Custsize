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
 * Class Yireo_Custsize_Block_Profiles
 */
class Yireo_Custsize_Block_Profiles extends Mage_Core_Block_Template
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profiles.phtml');
    }

    /**
     * Load the default profile
     *
     * @return null
     */
    public function getDefaultProfile()
    {
        $profiles = $this->getProfiles();
        if(!empty($profiles)) {
            foreach($profiles as $profile) {
                if($profile->getData('default') == 1) {
                    $profile->load($profile->getId());
                    return $profile;
                }
            }
        }
        return null;
    }

    /**
     * Load non-default profiles
     *
     * @return array
     */
    public function getOtherProfiles()
    {
        $profiles = $this->getProfiles();
        $rs = array();
        if(!empty($profiles)) {
            foreach($profiles as $profile) {
                /** @var Yireo_Custsize_Model_Profile $profile */
                if($profile->getData('default') == 0) {
                    $rs[] = $profile;
                }
            }
        }
        return $rs;
    }

    /**
     * Get a collection of profiles
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getProfiles()
    {
        static $profiles = null;
        if(empty($profiles)) {
            /** @var Mage_Customer_Model_Session $customerSession */
            $customerSession = Mage::getModel('customer/session');
            $customerId = $customerSession->getCustomerId();
            $profiles = Mage::getModel('custsize/profile')->getCollection()->addFieldToFilter('customer_id', $customerId);;
        }
        return $profiles;
    }

    /**
     * Load a listing of all fields that appear on the dashboard
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getDashboardFields()
    {
        $fields = Mage::getModel('custsize/profile_field')->getCollection()
            ->addFieldToFilter('enabled', 1)
            ->addFieldToFilter('dashboard', 1)
        ;
        return $fields;
    }

    /**
     * Get a URL for creating a new profile
     *
     * @return string
     */
    public function getNewUrl()
    {
        return $this->getUrl('custsize/index/profile', array('task' => 'new'));
    }

    /**
     * Get a URL for editing a profile
     *
     * @param Yireo_Custsize_Model_Profile $profile
     *
     * @return string
     */
    public function getEditUrl($profile)
    {
        $params = array(
            'task' => 'edit',
            'profile_id' => $profile->getData('profile_id'),
        );
        return $this->getUrl('custsize/index/profile', $params);
    }
}
