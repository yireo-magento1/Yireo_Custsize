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
 * Class Yireo_Custsize_Block_Admin_Fieldsets
 */
class Yireo_Custsize_Block_Admin_Fieldsets extends Yireo_Custsize_Block_Admin_Abstract
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/fieldsets.phtml');
    }

    /**
     * Prepare the layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()
            ->createBlock('custsize/admin_fieldsets_grid', 'fieldsets.grid')
            ->setSaveParametersInSession(true)
        );
        return parent::_prepareLayout();
    }
}
