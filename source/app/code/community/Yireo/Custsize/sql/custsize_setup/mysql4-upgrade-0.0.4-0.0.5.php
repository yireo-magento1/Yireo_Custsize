<?php
/**
 * Yireo Custsize
 *
 * @package     Yireo_Custsize
 * @author      Yireo (http://www.yireo.com/)
 * @copyright   Copyright 2015 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 */

/** @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer = $this;
$installer->startSetup();
$installer->updateAttribute('catalog_product', 'custsize', 'is_unique', 0);
$installer->endSetup();
