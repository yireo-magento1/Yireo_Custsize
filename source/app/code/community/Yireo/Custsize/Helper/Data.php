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
class Yireo_Custsize_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Helper method to get all values of a specific profile
     *
     * @param int $profile_id
     *
     * @return array
     */
    public function getProfileValues($profile_id)
    {
        $valueArray = array();
        $result = array();

        // Get the profile itself
        /** @var Yireo_Custsize_Model_Profile $profile */
        $profile = Mage::getModel('custsize/profile')->load($profile_id);
        $result[$this->__('Customer Profile')] = $profile->getName();

        // Get the value-collection and convert it into an array 
        $values = Mage::getModel('custsize/profile_value')->getCollection()
            ->addFieldToFilter('profile_id', $profile_id)
            ->load();

        foreach ($values as $value) {
            $valueArray[$value->getFieldId()] = $value->getValue();
        }

        // Get the field-collection
        $fields = Mage::getModel('custsize/profile_field')->getCollection()
            ->addFieldToFilter('enabled', 1)
            ->setOrder('ordering', 'ASC')
            ->load();

        // Create the result
        foreach ($fields as $field) {
            if (isset($valueArray[$field->getFieldId()])) {
                $result[$field->getLabel()] = $valueArray[$field->getFieldId()] . ' ' . $field->getUnit();
            }
        }

        return $result;
    }
}
