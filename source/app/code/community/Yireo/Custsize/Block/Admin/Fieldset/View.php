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

class Yireo_Custsize_Block_Admin_Fieldset_View extends Yireo_Custsize_Block_Admin_Fieldset_Abstract
{
    /**
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('custsize/fieldset/view.phtml');
    }
}
