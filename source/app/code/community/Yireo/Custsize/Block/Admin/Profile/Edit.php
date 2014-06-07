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

class Yireo_Custsize_Block_Admin_Profile_Edit extends Yireo_Custsize_Block_Admin_Profile_Abstract
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profile/edit.phtml');
    }

    /*
     * 
     */
    public function getTitle()
    {
        if($this->getProfileId() > 0) {
            return $this->__('Edit Size Profile');
        } else {
            return $this->__('New Size Profile');
        }
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        $this->setChild('delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('catalog')->__('Delete'),
                    'onclick' => 'setLocation(\''.$this->getConfirmdeleteUrl().'\');return false;',
                    'class' => 'delete'
                ))
        );

        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('catalog')->__('Save'),
                    'onclick' => 'custsizeForm.submit();',
                    'class' => 'save'
                ))
        );

        $this->setChild('copy_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('catalog')->__('Copy'),
                    'onclick' => 'setLocation(\''.$this->getCopyUrl().'\');return false;',
                    'class' => 'save'
                ))
        );

        $this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('catalog')->__('Back'),
                    'onclick' => 'setLocation(\''.$this->getCancelUrl().'\');return false;',
                    'class' => 'back'
                ))
        );

        return parent::_toHtml();
    }
}
