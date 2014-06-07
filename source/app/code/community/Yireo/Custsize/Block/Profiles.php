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

class Yireo_Custsize_Block_Profiles extends Mage_Core_Block_Template
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profiles.phtml');
    }

    public function getDefaultProfile()
    {
        $profiles = $this->getProfiles();
        if(!empty($profiles)) {
            foreach($profiles as $profile) {
                if($profile->getData('default') == 1) return $profile;
            }
        }
        return null;
    }

    public function getOtherProfiles()
    {
        $profiles = $this->getProfiles();
        $rs = array();
        if(!empty($profiles)) {
            foreach($profiles as $profile) {
                if($profile->getData('default') == 0) $rs[] = $profile;
            }
        }
        return $rs;
    }

    public function getProfiles()
    {
        static $profiles = null;
        if(empty($profiles)) {
            $customerId = Mage::getModel('customer/session')->getCustomerId();
            $profiles = Mage::getModel('custsize/profile')->getCollection()->addFieldToFilter('customer_id', $customerId);;
        }
        return $profiles;
    }

    public function getNewUrl()
    {
        return $this->getUrl('custsize/index/profile', array('task' => 'new'));
    }

    public function getEditUrl($profile)
    {
        $params = array(
            'task' => 'edit',
            'profile_id' => $profile->getData('profile_id'),
        );
        return $this->getUrl('custsize/index/profile', $params);
    }
}
