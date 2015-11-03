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
class Yireo_Custsize_Helper_Definitions extends Mage_Core_Helper_Abstract
{
    /**
     * Method to get all possible units
     *
     * @return array
     */
    public function getUnits()
    {
        return array(
            'cm' => 'Centimeter',
            'mm' => 'Millimeter',
            'kg' => 'Kilograms',
            'liter' => 'Liters',
            'inch' => 'Inches',
        );
    }
}
