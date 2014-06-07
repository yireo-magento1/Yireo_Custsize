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

class Yireo_Custsize_Block_Admin_Profiles_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    private $_customerId = 0;

    public function __construct()
    {
        parent::__construct();
        $this->setId('profilesGrid');
        $this->setDefaultSort('ordering');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);

        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        if(strstr($currentUrl, 'customer/edit')) {
            $this->setCustomerId((int)$this->getRequest()->getParam('id', 0));
        }
    }

    protected function _prepareLayout()
    {
        $this->setChild('new_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('New'),
                    'onclick'   => 'setLocation(\''.$this->getNewUrl().'\')',
                    'class'   => 'task'
                ))
        );

        return parent::_prepareLayout();
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('custsize/profile')->getCollection();
        if($this->hasCustomer()) $collection->addFieldToFilter('customer_id', $this->getCustomerId());

        foreach($collection as $item) {
            if($this->hasCustomer() == false) {
                $customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
                $item->setData('customer_name', $customer->getName());
            }
            $item->setData('default', ($item->getData('default') == 1) ? 'Yes' : 'No' );
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('profile_id', array(
            'header'=> Mage::helper('custsize')->__('Profile ID'),
            'width' => '50px',
            'index' => 'profile_id',
            'type' => 'number',
        ));

        if($this->hasCustomer() == false) {
            $this->addColumn('customer_name', array(
                'header'=> Mage::helper('custsize')->__('Customer'),
                'width' => '350px',
                'index' => 'customer_name',
                'type' => 'text',
                'filter'    => false,
                'sortable'  => false,
            ));
        }

        $this->addColumn('name', array(
            'header'=> Mage::helper('custsize')->__('Name'),
            'width' => '200px',
            'index' => 'name',
            'type' => 'text',
        ));

        $this->addColumn('default', array(
            'header'=> Mage::helper('custsize')->__('Default'),
            'index' => 'default',
            'type' => 'text',
        ));

        $this->addColumn('ordering', array(
            'header'=> Mage::helper('custsize')->__('Ordering'),
            'width' => '50px',
            'index' => 'ordering',
            'type' => 'number',
        ));

        $baseEditUrl = 'adminhtml/custsize/profile/task/edit';
        if($this->hasCustomer()) $baseEditUrl .= '/customer_id/'.$this->getCustomerId();
        $this->addColumn('actions', array(
            'header'=> Mage::helper('custsize')->__('Action'),
            'type' => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('custsize')->__('Edit'),
                    'url' => array('base' => $baseEditUrl),
                    'field' => 'profile_id'
                )
            ),
            'filter' => false,
            'sortable' => false,
        ));

        return parent::_prepareColumns();
    }

    public function getNewUrl()
    {
        $params = array(
            'task' => 'new',
        );

        if($this->hasCustomer()) {
            $params['customer_id'] = $this->getCustomerId();
        }

        return $this->getUrl('adminhtml/custsize/profile', $params);
    }

    public function getNewButtonHtml()
    {
        if($this->hasCustomer() == true) {
            return $this->getChildHtml('new_button');
        }
        return null;
    }

    public function getRowUrl($row)
    {
        $params = array(
            'task' => 'edit',
            'profile_id' => $row->getId(),
        );

        if($this->hasCustomer()) {
            $params['customer_id'] = $this->getCustomerId();
        } else {
            $params['customer_id'] = $row->getCustomerId();
        }

        return $this->getUrl('adminhtml/custsize/profile', $params);
    }

    public function getMainButtonsHtml()
    {
        $html = parent::getMainButtonsHtml();
        $html = $html . $this->getNewButtonHtml();
        return $html;
    }

    protected function setCustomerId($customerId = 0)
    {
        $this->_customerId = $customerId;
    }

    protected function getCustomerId()
    {
        return $this->_customerId;
    }

    protected function hasCustomer()
    {
        if($this->getCustomerId() > 0) {
            return true;
        } 
        return false;
    }
}
