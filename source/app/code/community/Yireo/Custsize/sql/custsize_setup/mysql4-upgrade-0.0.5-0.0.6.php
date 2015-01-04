<?php
/**
 * Yireo Custsize
 *
 * @package     Yireo_Custsize
 * @author      Yireo (http://www.yireo.com/)
 * @copyright   Copyright 2015 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 */

/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('custsize_profile_fieldset')}` (
  `fieldset_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fieldset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");

$installer->run("INSERT INTO `{$this->getTable('custsize_profile_fieldset')}` (`fieldset_id`, `label`, `tag`) VALUES ('1', 'Basic', 'basic');");
$installer->run("INSERT INTO `{$this->getTable('custsize_profile_fieldset')}` (`fieldset_id`, `label`, `tag`) VALUES ('2', 'Measurements', 'measurements');");

$installer->endSetup();
