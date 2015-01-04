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

class Yireo_Custsize_Block_Admin_Fieldsets extends Yireo_Custsize_Block_Admin_Abstract
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/fieldsets.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()
            ->createBlock('custsize/admin_fieldsets_grid', 'fieldsets.grid')
            ->setSaveParametersInSession(true)
        );
        return parent::_prepareLayout();
    }
}
