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

class Yireo_Custsize_Block_Admin_Field_Abstract extends Yireo_Custsize_Block_Admin_Abstract
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();

        // Set the field ID
        $this->setFieldId((int)$this->getRequest()->getParam('field_id', 0));

        // Set the field
        $this->setField(Mage::getModel('custsize/profile_field')->load($this->getFieldId()));
    }

    /*
     * Get the save URL
     */
    public function getSaveUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/custsize/field', array('task' => 'save', 'field_id' => $this->getFieldId()));
    }

    /*
     * Get the cofirmdelete URL
     */
    public function getDeleteUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/custsize/field', array('task' => 'delete', 'field_id' => $this->getFieldId()));
    }

    /*
     * Get the cofirmdelete URL
     */
    public function getFieldsetsUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/custsize/fieldsets');
    }
}
