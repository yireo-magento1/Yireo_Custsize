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
 * Class Yireo_Custsize_Block_Rewrite_Checkout_Cart_Item_Renderer
 */
class Yireo_Custsize_Block_Rewrite_Checkout_Cart_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{
    /**
     * @return array
     */
    public function getOptionList()
    {
        $result = parent::getOptionList();
        $item = $this->getItem();

        $custsize = null;
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
