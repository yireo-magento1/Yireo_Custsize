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
 * Class Yireo_Custsize_Block_Admin_Field_Abstract
 */
class Yireo_Custsize_Block_Admin_Field_Abstract extends Yireo_Custsize_Block_Admin_Abstract
{
    /**
     * @var Mage_Adminhtml_Helper_Data
     */
    protected $helper;

    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();

        // Set the field ID
        $this->setFieldId((int)$this->getRequest()->getParam('field_id', 0));

        // Set the field
        $this->setField(Mage::getModel('custsize/profile_field')->load($this->getFieldId()));

        $this->helper = Mage::helper('adminhtml');
    }

    /**
     * Get the save URL
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->helper->getUrl('adminhtml/custsize/field', array('task' => 'save', 'field_id' => $this->getFieldId()));
    }

    /**
     * Get the cofirmdelete URL
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->helper->getUrl('adminhtml/custsize/field', array('task' => 'delete', 'field_id' => $this->getFieldId()));
    }

    /**
     * Get the cofirmdelete URL
     *
     * @return string
     */
    public function getFieldsetsUrl()
    {
        return $this->helper->getUrl('adminhtml/custsize/fieldsets');
    }
}
