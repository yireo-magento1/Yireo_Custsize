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

class Yireo_Custsize_Block_Admin_Fieldset_Abstract extends Mage_Adminhtml_Block_Widget_Container
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();

        // Set the fieldset ID
        $this->setFieldsetId((int)$this->getRequest()->getParam('fieldset_id', 0));

        // Set the fieldset
        $this->setFieldset(Mage::getModel('custsize/profile_fieldset')->load($this->getFieldsetId()));
    }

    /*
     * Get the save URL
     */
    public function getSaveUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/custsize/fieldset', array('task' => 'save', 'fieldset_id' => $this->getFieldsetId()));
    }

    /*
     * Get the cofirmdelete URL
     */
    public function getDeleteUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/custsize/fieldset', array('task' => 'delete', 'fieldset_id' => $this->getFieldsetId()));
    }

    /*
     * Get the fields-overview URL
     */
    public function getFieldsUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/custsize/fields');
    }
}
