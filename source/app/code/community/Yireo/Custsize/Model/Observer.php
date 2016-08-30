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
 * Class Yireo_Custsize_Model_Observer
 */
class Yireo_Custsize_Model_Observer
{
    /**
     * Event "checkout_cart_add_product_complete" - after a product has been added to the cart
     *
     * @deprecated
     */
    public function checkoutCartAddProductComplete($observer)
    {
        return $this;
    }
}
