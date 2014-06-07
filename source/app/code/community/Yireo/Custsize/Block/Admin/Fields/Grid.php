<?php
/**
 * Yireo Custsize
 *
 * @author      Yireo (http://www.yireo.com/)
 * @package     Yireo_Custsize
 * @copyright   Copyright (C) 2014 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 * @link        http://www.yireo.com/
 */

class Yireo_Custsize_Block_Admin_Fields_Grid extends Yireo_Custsize_Block_Admin_Abstract_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('fieldsGrid');
        $this->setDefaultSort('ordering');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareLayout()
    {
        $this->getButtonChildBlock('new', 'New', $this->getNewUrl(), null, 'task');
        $this->getButtonChildBlock('fieldsets', 'Manage Fieldsets', $this->getFieldsetsUrl(), null, 'back');
        return parent::_prepareLayout();
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('custsize/profile_field')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('field_id', array(
            'header'=> Mage::helper('custsize')->__('Field ID'),
            'width' => '50px',
            'index' => 'field_id',
            'type' => 'number',
        ));

        $this->addColumn('label', array(
            'header'=> Mage::helper('custsize')->__('Label'),
            'width' => '350px',
            'index' => 'label',
            'type' => 'text',
        ));

        $this->addColumn('unit', array(
            'header'=> Mage::helper('custsize')->__('Unit'),
            'width' => '80px',
            'index' => 'unit',
            'type' => 'text',
        ));

        $this->addColumn('marker', array(
            'header'=> Mage::helper('custsize')->__('Marker'),
            'index' => 'marker',
            'type' => 'text',
        ));

        $this->addColumn('fieldset', array(
            'header'=> Mage::helper('custsize')->__('Fieldset'),
            'index' => 'fieldset',
            'type' => 'text',
        ));

        $this->addColumn('fieldtype', array(
            'header'=> Mage::helper('custsize')->__('Fieldtype'),
            'index' => 'fieldtype',
            'type' => 'text',
        ));

        $this->addColumn('enabled', array(
            'header'=> Mage::helper('custsize')->__('Enabled'),
            'width' => '50px',
            'index' => 'enabled',
            'frame_callback' => array($this, 'decorateBoolean')
        ));

        $this->addColumn('required', array(
            'header'=> Mage::helper('custsize')->__('Required'),
            'width' => '50px',
            'index' => 'required',
            'frame_callback' => array($this, 'decorateBoolean')
        ));

        $this->addColumn('dashboard', array(
            'header'=> Mage::helper('custsize')->__('Dashboard'),
            'width' => '50px',
            'index' => 'dashboard',
            'frame_callback' => array($this, 'decorateBoolean')
        ));

        $this->addColumn('ordering', array(
            'header'=> Mage::helper('custsize')->__('Ordering'),
            'width' => '100px',
            'index' => 'ordering',
            'type' => 'number',
        ));

        $this->addColumn('actions', array(
            'header'=> Mage::helper('custsize')->__('Action'),
            'type' => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('custsize')->__('Edit'),
                    'url' => array('base' => '*/*/field/task/edit'),
                    'field' => 'field_id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
        ));

        return parent::_prepareColumns();
    }

    public function getNewUrl()
    {
        return $this->getUrl('*/*/field', array('task' => 'new'));
    }

    public function getFieldsetsUrl()
    {
        return $this->getUrl('*/*/fieldsets');
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/field', array(
            'task' => 'edit',
            'field_id' => $row->getId())
        );
    }
}
