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
 * Class Yireo_Custsize_Block_Rewrite_Adminhtml_Order_Item_Name
 */
class Yireo_Custsize_Block_Rewrite_Adminhtml_Order_Item_Name extends Mage_Adminhtml_Block_Sales_Items_Column_Name
{
    /**
     * @return array
     */
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
