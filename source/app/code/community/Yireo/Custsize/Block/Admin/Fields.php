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
 * Class Yireo_Custsize_Block_Admin_Fields
 */
class Yireo_Custsize_Block_Admin_Fields extends Yireo_Custsize_Block_Admin_Abstract
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/fields.phtml');
    }

    /**
     * Prepare the layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()
            ->createBlock('custsize/admin_fields_grid', 'fields.grid')
            ->setSaveParametersInSession(true)
        );
        return parent::_prepareLayout();
    }
}
