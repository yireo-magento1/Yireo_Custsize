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

$installer->addAttribute('catalog_product', 'custsize', array(
    'type'              => 'int',
    'backend'           => '',
    'frontend'          => '',
    'label'             => 'Customer Size',
    'input'             => 'select',
    'class'             => '',
    'source'            => 'eav/entity_attribute_source_boolean',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => false,
    'default'           => '0',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'simple,configurable,virtual,bundle,grouped',
    'is_configurable'   => false
));

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('custsize_profile')}` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `profile_customer` (`profile_id`,`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('custsize_profile_field')}` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `marker` varchar(10) NOT NULL,
  `fieldset` varchar(255) NOT NULL,
  `fieldtype` varchar(50) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('custsize_profile_value')}` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");

$installer->endSetup();
