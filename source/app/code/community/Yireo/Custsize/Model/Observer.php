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

class Yireo_Custsize_Model_Observer
{
    /**
     * Event "checkout_cart_add_product_complete" - after a product has been added to the cart
     */
    public function checkoutCartAddProductComplete($observer)
    {
        // Get objects from the event
        $product = $observer->getEvent()->getProduct();
        $request = $observer->getEvent()->getRequest();
        $params = $request->getParams();

        if(isset($params['custsize_profile_id'])) {

            // Get the current quote
            $quote = Mage::getSingleton('checkout/session')->getQuote();

            // Search the quote for the current product
            $items = $quote->getAllItems();
            $quoteProduct = null;
            foreach ($items as $item) {
                if ($item->getProductId() == $product->getId()) {
                    $quoteProduct = $item;
                    break;
                }
            }

            $profileId = $params['custsize_profile_id'];
            if($quoteProduct != null && $profileId > 0) {

                // Load the custsize data into an array
                $custsizeData = Mage::helper('custsize')->getProfileValues($profileId);

                // Add extra data within the quote
                $this->addAdditionalData($quoteProduct, 'custsize', $custsizeData);

                // Save the changed information
                $quoteProduct->save();

            }
        }

        return $this;
    }

    /**
     * Method to add additional_data to an object
     *
     * @param $item
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    protected function addAdditionalData(&$item, $key, $value)
    {
        $data = unserialize($item->getAdditionalData());
        if(!is_array($data)) {
            $data = array();
        }

        $data[$key] = $value;

        $item->setAdditionalData(serialize($data));
        return $item;
    }
}
