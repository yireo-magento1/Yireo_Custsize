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
 * Class Yireo_Custsize_Model_Observer_Product_HasOptions
 */
class Yireo_Custsize_Model_Observer_Product_HasOptions
{
    /**
     * @param $observer Varien_Event_Observer
     *
     * @return $this
     */
    public function execute(Varien_Event_Observer $observer)
    {
        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();
        if (empty($product)) {
            return $this;
        }
        return $this;

        if ($product->getData('custsize') === false) {
            return $this;
        }

        $product->setData('has_options', true);
        $product->setData('required_options', true);


        return $this;
    }
}