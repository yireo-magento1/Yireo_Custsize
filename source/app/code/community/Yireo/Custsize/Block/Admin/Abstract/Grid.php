<?php
/**
 * Yireo Commons - Abstract admin-grid class
 *
 * @author      Yireo (https://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright 2015 Yireo (https://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        https://www.yireo.com/
 */

/**
 * Class Yireo_Custsize_Block_Admin_Abstract_Grid
 */
class Yireo_Custsize_Block_Admin_Abstract_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @var array
     */
    protected $buttonsChildBlocks = array();

    /**
     * @param string $action
     * @param string $title
     * @param string $url
     * @param string $onclick
     * @param string $class
     */
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

    /**
     * @return string
     */
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

    /**
     * @param $value
     * @param $row
     * @param $column
     * @param $isExport
     *
     * @return string
     */
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
