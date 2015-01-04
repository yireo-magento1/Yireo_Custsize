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

class Yireo_Custsize_Block_Admin_Fieldsets_Grid extends Yireo_Custsize_Block_Admin_Abstract_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('fieldsetsGrid');
        $this->setDefaultSort('ordering');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(false);
    }

    protected function _prepareLayout()
    {
        $this->getButtonChildBlock('new', 'New', $this->getNewUrl(), null, 'task');
        $this->getButtonChildBlock('fields', 'Manage Fields', $this->getFieldsUrl(), null, 'back');
        return parent::_prepareLayout();
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('custsize/profile_fieldset')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('fieldset_id', array(
            'header'=> Mage::helper('custsize')->__('Fieldset ID'),
            'width' => '50px',
            'index' => 'fieldset_id',
            'type' => 'number',
        ));

        $this->addColumn('label', array(
            'header'=> Mage::helper('custsize')->__('Label'),
            'width' => '350px',
            'index' => 'label',
            'type' => 'text',
        ));

        $this->addColumn('tag', array(
            'header'=> Mage::helper('custsize')->__('Tag'),
            'width' => '350px',
            'index' => 'tag',
            'type' => 'text',
        ));

        $this->addColumn('enabled', array(
            'header'=> Mage::helper('custsize')->__('Enabled'),
            'width' => '50px',
            'index' => 'enabled',
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
                    'url' => array('base' => '*/*/fieldset/task/edit'),
                    'field' => 'fieldset_id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
        ));

        return parent::_prepareColumns();
    }

    public function getNewUrl()
    {
        return $this->getUrl('*/*/fieldset', array('task' => 'new'));
    }

    public function getFieldsUrl()
    {
        return $this->getUrl('*/*/fields');
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/fieldset', array(
            'task' => 'edit',
            'fieldset_id' => $row->getId())
        );
    }
}
