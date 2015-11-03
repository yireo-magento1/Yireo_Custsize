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

/**
 * Class Yireo_Custsize_Block_Admin_Profiles
 */
class Yireo_Custsize_Block_Admin_Profiles extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/profiles.phtml');
    }

    /**
     * Prepare the layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()
            ->createBlock('custsize/admin_profiles_grid', 'profiles.grid')
            ->setSaveParametersInSession(true)
        );
        return parent::_prepareLayout();
    }

    /**
     * Return the child blocks grid HTML
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
