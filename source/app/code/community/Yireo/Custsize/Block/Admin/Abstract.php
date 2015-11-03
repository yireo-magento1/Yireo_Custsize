<?php
/**
 * Yireo Commons - Abstract admin-container class
 *
 * @author      Yireo (http://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright 2015 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        http://www.yireo.com/
 */

/**
 * Class Yireo_Custsize_Block_Admin_Abstract
 */
class Yireo_Custsize_Block_Admin_Abstract extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * Modify the HTML code of this block
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html = parent::_toHtml();
        $html .= $this->getFooter();
        return $html;
    }

    /**
     * Return the footer
     *
     * @return mixed
     */
    public function getFooter()
    {
        /** @var Mage_Core_Block_Template $block */
        $block = $this->getLayout()->createBlock('core/template')->setTemplate('custsize/footer.phtml');
        $block->setVersion($this->getVersion());
        $block->setTitle('Customer Sizes');
        return $block->toHtml();
    }

    /**
     * Return the current version
     *
     * @return string
     */
    public function getVersion()
    {
        $config = Mage::app()->getConfig()->getModuleConfig('Yireo_Custsize');
        return (string)$config->version;
    }

    /**
     * Return the child blocks HTML containing the grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    /**
     * Return a block containing
     *
     * @param $action
     * @param $title
     * @param null $url
     * @param null $onclick
     * @param string $class
     */
    public function getButtonChildBlock($action, $title, $url = null, $onclick = null, $class = 'save')
    {
        if(empty($onclick) && !empty($url)) {
            $onclick = 'setLocation(\''.$url.'\');return false;';
        }

        $buttonBlock = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('core')->__($title),
                'onclick' => $onclick,
                'class' => $class
            ));

        $this->setChild($action.'_button', $buttonBlock);
    }
}
