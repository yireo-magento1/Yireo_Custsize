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

class Yireo_Custsize_Model_Profile extends Mage_Core_Model_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('custsize/profile');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();
        if($this->getProfileId() == 0) $this->setData('created_on', date('Y-m-d H:i:s'));
        $this->setData('modified_on', date('Y-m-d H:i:s'));

        return $this;
    }

    protected function _afterDelete()
    {
        $currentValues = Mage::getModel('custsize/profile_value')->getCollection()
            ->addFieldToFilter('profile_id', $this->getProfileId())
        ;
        foreach($currentValues as $currentValue) {
            $currentValue->delete();
        }
    }

    protected function _afterLoad()
    {
        $currentValues = Mage::getModel('custsize/profile_value')->getCollection()
            ->addFieldToFilter('profile_id', $this->getProfileId())
        ;
        foreach($currentValues as $currentValue) {
            $this->setData('field'.$currentValue->getFieldId(), $currentValue->getValue());
        }
    }

    public function saveFields($fieldIds, $profileId = 0)
    {
        if($profileId == 0) {
            return false;
        }

        $currentValues = Mage::getModel('custsize/profile_value')->getCollection()
            ->addFieldToFilter('profile_id', $profileId)
        ;
        if(!empty($fieldIds)) {
            foreach($fieldIds as $fieldId => $fieldValue) {
                foreach($currentValues as $currentValue) {
                    if($currentValue->getFieldId() == $fieldId) {
                        $currentValue->setValue($fieldValue);
                        $currentValue->save();
                        unset($fieldIds[$fieldId]);
                        break;
                    }    
                }
            }
        }

        foreach($fieldIds as $fieldId => $fieldValue) {
            $value = Mage::getModel('custsize/profile_value');
            $value->setFieldId($fieldId);
            $value->setProfileId($profileId);
            $value->setValue($fieldValue);
            $value->save();
        }
        
        return true;
    }
}
