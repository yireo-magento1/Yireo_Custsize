<?php
/**
 * Yireo Commons - Abstract admin-container class
 *
 * @author      Yireo (http://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright (C) 2014 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        http://www.yireo.com/
 */

class Yireo_Custsize_Block_Admin_Abstract extends Mage_Adminhtml_Block_Widget_Container
{
    protected function _toHtml()
    {
        $html = parent::_toHtml();
        $html .= $this->getFooter();
        return $html;
    }

    public function getFooter()
    {
        $block = $this->getLayout()->createBlock('core/template')->setTemplate('custsize/footer.phtml');
        $block->setVersion($this->getVersion());
        $block->setTitle('Customer Sizes');
        return $block->toHtml();
    }

    /**
     * Return the current version
     *
     * @access public
     * @param null
     * @return string
     */
    public function getVersion()
    {
        $config = Mage::app()->getConfig()->getModuleConfig('Yireo_Custsize');
        return (string)$config->version;
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    public function getButtonChildBlock($action, $title, $url = null, $onclick = null, $class = 'save')
    {
        if(empty($onclick) && !empty($url)) $onclick = 'setLocation(\''.$url.'\');return false;';

        $this->setChild($action.'_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('core')->__($title),
                    'onclick' => $onclick,
                    'class' => $class
                ))
        );
    }
}
