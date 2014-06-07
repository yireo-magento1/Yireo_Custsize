<?php
/**
 * Yireo Custsize
 *
 * @author      Yireo (http://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright (C) 2014 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        http://www.yireo.com/
 */

class Yireo_Custsize_Block_Rewrite_Sales_Order_Email_Items_Default extends Mage_Sales_Block_Order_Email_Items_Default
{
    /*
     * Override of original method
     *
     * @access public
     * @param null
     * @return array
     */
    public function getItemOptions()
    {
        $result = parent::getItemOptions();
        $item = $this->getItem()->getOrderItem();
    
        $data = unserialize($item->getAdditionalData());
        if(!empty($data) && isset($data['custsize'])) {
            foreach($data['custsize'] as $name => $value) {
                $result[] = array(
                    'label' => $name,
                    'value' => $value,
                );
            }
        }

        return $result;
    }
}
