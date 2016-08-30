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
 * Class Yireo_Custsize_Model_Observer_Checkout_AddProfileData
 */
class Yireo_Custsize_Model_Observer_Checkout_CheckChosenProfile
{
    /**
     * Event "checkout_cart_add_product_complete" - after a product has been added to the cart
     */
    public function execute($observer)
    {
        // Get objects from the event
        $product = $observer->getEvent()->getProduct();
        $request = Mage::app()->getRequest();
        $params = $request->getParams();

        if (!$product->getCustsize()) {
            return $this;
        }

        if(!empty($params['custsize_profile_id'])) {
            return $this;
        }

        Mage::getSingleton('core/session')->addNotice('Please select a profile first');

        $response = Mage::app()->getResponse();
        $response->setRedirect($product->getProductUrl());
        $response->sendResponse();
        exit;
    }
}
