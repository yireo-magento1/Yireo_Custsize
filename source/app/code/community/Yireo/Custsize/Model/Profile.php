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
 * Class Yireo_Custsize_Model_Profile
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

    /**
     * Auto-correct data before saving
     *
     * @return $this
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();

        if ($this->getProfileId() == 0) {
            $this->setData('created_on', date('Y-m-d H:i:s'));
        }

        $this->setData('modified_on', date('Y-m-d H:i:s'));

        return $this;
    }

    /**
     * Remove old profile values when deleting this profile
     */
    protected function _afterDelete()
    {
        $currentValues = Mage::getModel('custsize/profile_value')->getCollection()
            ->addFieldToFilter('profile_id', $this->getProfileId());

        foreach ($currentValues as $currentValue) {
            /** @var Yireo_Custsize_Model_Profile_Field $currentValue */
            $currentValue->delete();
        }
    }

    /**
     * Append profile values once this profile is loaded
     */
    protected function _afterLoad()
    {
        $currentValues = Mage::getModel('custsize/profile_value')->getCollection()
            ->addFieldToFilter('profile_id', $this->getProfileId());

        foreach ($currentValues as $currentValue) {
            $this->setData('field' . $currentValue->getFieldId(), $currentValue->getValue());
        }
    }

    /**
     * @param $fieldIds
     * @param int $profileId
     *
     * @return bool
     * @throws Exception
     */
    public function saveFields($fieldIds, $profileId = 0)
    {
        if ($profileId == 0) {
            return false;
        }

        $currentValues = Mage::getModel('custsize/profile_value')->getCollection()
            ->addFieldToFilter('profile_id', $profileId);

        if (!empty($fieldIds)) {
            foreach ($fieldIds as $fieldId => $fieldValue) {
                foreach ($currentValues as $currentValue) {
                    /** @var Yireo_Custsize_Model_Profile_Field $currentValue */
                    if ($currentValue->getFieldId() == $fieldId) {
                        $currentValue->setValue($fieldValue);
                        $currentValue->save();
                        unset($fieldIds[$fieldId]);
                        break;
                    }
                }
            }
        }

        foreach ($fieldIds as $fieldId => $fieldValue) {
            /** @var Yireo_Custsize_Model_Profile_Field $value */
            $value = Mage::getModel('custsize/profile_value');
            $value->setFieldId($fieldId);
            $value->setProfileId($profileId);
            $value->setValue($fieldValue);
            $value->save();
        }

        return true;
    }
}
