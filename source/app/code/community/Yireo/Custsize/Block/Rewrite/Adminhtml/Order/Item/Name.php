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

class Yireo_Custsize_Block_Rewrite_Adminhtml_Order_Item_Name extends Mage_Adminhtml_Block_Sales_Items_Column_Name
{
    public function getOrderOptions()
    {
        $result = parent::getOrderOptions();
        $item = $this->getItem();

        $data = unserialize($item->getAdditionalData());
        if(!empty($data) && isset($data['custsize'])) {
            foreach($data['custsize'] as $name => $value) {
                $result[] = array(
                    'label' => $name,
                    'custom_view' => 1,
                    'value' => $value,
                );
            }
        }

        return $result;
    }
}
