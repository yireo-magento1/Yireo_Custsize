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

class Yireo_Custsize_Block_Admin_Field_Edit extends Yireo_Custsize_Block_Admin_Field_Abstract
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/field/edit.phtml');
    }

    /*
     * 
     */
    public function getTitle()
    {
        if($this->getFieldId() > 0) {
            return $this->__('Edit Size Field');
        } else {
            return $this->__('New Size Field');
        }
    }

    /*
     * Get the available fieldsets
     */
    public function getFieldsets()
    {
        return Mage::getModel('custsize/profile_fieldset')->getCollection();
    }

    /*
     * Get the available units
     */
    public function getUnits()
    {
        return Mage::helper('custsize/definitions')->getUnits();
    }

    /*
     * Construct a simple yes-no selector
     */
    public function getYesno($name, $value)
    {
        $selected_yes = ($value == 1) ? 'checked' : null;
        $selected_no = ($value == 0) ? 'checked' : null;

        $html = null;
        $html .= '<input type="radio" name="field['.$name.']" id="'.$name.'_yes" value="1" '.$selected_yes.' />';
        $html .= '&nbsp;<label for="'.$name.'_yes">'.$this->__('Yes').'</label>';
        $html .= '&nbsp;<input type="radio" name="field['.$name.']" id="'.$name.'_no" value="0" '.$selected_no.' />';
        $html .= '&nbsp;<label for="'.$name.'_no">'.$this->__('No').'</label>';
        return $html;
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
                    'onclick' => 'setLocation(\''.$this->getDeleteUrl().'\');return false;',
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

        $this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('catalog')->__('Back'),
                    'onclick' => 'setLocation(\''.$this->getUrl('adminhtml/custsize/fields').'\'); return false;',
                    'class' => 'back'
                ))
        );

        return parent::_toHtml();
    }
}
