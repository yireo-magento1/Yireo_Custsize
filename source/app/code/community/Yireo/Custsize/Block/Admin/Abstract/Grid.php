<?php
/**
 * Yireo Commons - Abstract admin-grid class
 *
 * @author      Yireo (http://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright 2015 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        http://www.yireo.com/
 */

class Yireo_Custsize_Block_Admin_Abstract_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $buttonsChildBlocks = array();

    public function getButtonChildBlock($action, $title, $url = null, $onclick = null, $class = 'save')
    {
        if(empty($onclick) && !empty($url)) $onclick = 'setLocation(\''.$url.'\');return false;';
        $action = $action.'_button';

        $this->setChild($action,
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('core')->__($title),
                    'onclick' => $onclick,
                    'class' => $class
                ))
        );
        $this->buttonsChildBlocks[] = $action;
    }

    public function getMainButtonsHtml()
    {
        $html = parent::getMainButtonsHtml();
        if(!empty($this->buttonsChildBlocks)) {
            foreach($this->buttonsChildBlocks as $buttonsChildBlock) {
                $html .= $this->getChildHtml($buttonsChildBlock);
            }
        }
        return $html;
    }

    public function decorateBoolean($value, $row, $column, $isExport)
    {
        $class = '';
        if($value == 1) {
            $label = $this->__('Yes');
            $class = 'grid-severity-notice';
        } else {
            $label = $this->__('No');
            $class = 'grid-severity-critical';
        }

        return '<span class="'.$class.'"><span>'.$label.'</span></span>';
    }
}
