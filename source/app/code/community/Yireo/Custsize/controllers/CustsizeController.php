<?php
/**
 * Yireo Custsize
 *
 * @package     Yireo_Custsize
 * @author      Yireo (http://www.yireo.com/)
 * @copyright   Copyright 2015 Yireo (http://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 */

/**
 * Custsize controller for the backend
 */
class Yireo_Custsize_CustsizeController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Common method
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customer/profile')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Customers'), Mage::helper('adminhtml')->__('Customers'))
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Memberships'), Mage::helper('adminhtml')->__('Memberships'))
        ;
        return $this;
    }

    /**
     * Display profiles of this customer
     *
     */
    public function profilesAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_profiles'))
            ->renderLayout();
    }

    /**
     * Perform a profile task
     */
    public function profileAction()
    {
        $this->setProfileId((int)$this->getRequest()->getParam('profile_id', 0));
        $this->setProfile(Mage::getModel('custsize/profile')->load($this->getProfileId()));

        $task = $this->getRequest()->getParam('task', null);
        switch($task) {
            case 'save':
                $this->saveProfile();
                break;
            case 'copy':
                $this->copyProfile();
                break;
            case 'confirmdelete':
                $this->confirmdeleteProfile();
                break;
            case 'delete':
                $this->deleteProfile();
                break;
            case 'edit':
            case 'new':
                $this->editProfile();
                break;
            default:
                $this->viewProfile();
                break;
        }
    }

    /**
     * Confirm delete of a specific profile
     */
    protected function confirmdeleteProfile()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_profile_confirmdelete'))
            ->renderLayout();
    }

    /**
     * View a specific profile
     */
    protected function viewProfile()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_profile_view'))
            ->renderLayout();
    }

    /**
     * Create a new profile or edit a specific profile
     */
    protected function editProfile()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_profile_edit'))
            ->renderLayout();
    }

    /**
     * Save a specific profile or a new profile
     */
    public function saveProfile()
    {
        $profile = $this->getProfile();
        if ($this->getRequest()->isPost()) {

            $profileData = $this->getRequest()->getPost('profile');
            if(!isset($profileData['default'])) $profileData['default'] = 0;
            foreach($profileData as $name => $value) {
                $profile->setData($name, $value);
            }

            $profile->save();

            // Save the fields belonging to this profile
            $fieldData = $this->getRequest()->getPost('field');
            $rs = $profile->saveFields($fieldData, $profile->getProfileId());

            Mage::getModel('core/session')->addSuccess('Successfully saved profile');
        }

        $this->redirectProfileOverview();
        return;
    }

    /**
     * Copy of a specific profile 
     */
    public function copyProfile()
    {
        // Get the original profile
        $profile = $this->getProfile();
        $oldProfileId = $profile->getProfileId();

        // Reset values and save the copy
        $profile->setName($profile->getName().' [copy]');
        $profile->setProfileId(null);
        $profile->save();

        // Copy the fields as well
        $currentValues = Mage::getModel('custsize/profile_value')->getCollection()->addFieldToFilter('profile_id', $oldProfileId);
        $fieldData = array();
        foreach($currentValues as $value) {
            $fieldData[$value->getFieldId()] = $value->getValue();
        }

        // Save the fields
        $profile->saveFields($fieldData, $profile->getProfileId());

        // Set a message
        Mage::getModel('core/session')->addSuccess('Successfully copied profile');

        // Redirect to the newly created profile-edit
        $this->_redirect('adminhtml/custsize/profile', array('task' => 'edit', 'profile_id' => $profile->getId()));
        return;
    }

    /**
     * Delete a specific profile
     */
    protected function deleteProfile()
    {
        $profile = $this->getProfile();
        $profile->delete();
        Mage::getModel('core/session')->addSuccess('Successfully deleted profile');

        $this->_redirect('adminhtml/custsize/profiles');
        return;
    }

    /**
     * Display fields
     *
     */
    public function fieldsAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_fields'))
            ->renderLayout();
    }

    /**
     * Perform a field task
     */
    public function fieldAction()
    {
        $this->setFieldId((int)$this->getRequest()->getParam('field_id', 0));
        $this->setField(Mage::getModel('custsize/profile_field')->load($this->getFieldId()));

        $task = $this->getRequest()->getParam('task', null);
        switch($task) {
            case 'save':
                $this->saveField();
                break;
            case 'delete':
                $this->deleteField();
                break;
            case 'edit':
            case 'new':
                $this->editField();
                break;
        }
    }

    /**
     * View a specific field
     */
    protected function viewField()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_field_view'))
            ->renderLayout();
    }

    /**
     * Create a new field or edit a specific field
     */
    protected function editField()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_field_edit'))
            ->renderLayout();
    }

    /**
     * Save a specific field or a new field
     */
    public function saveField()
    {
        $field = $this->getField();
        if ($this->getRequest()->isPost()) {

            $fieldData = $this->getRequest()->getPost('field');
            foreach($fieldData as $name => $value) {
                if($name == 'field_id' && empty($value)) continue;
                $field->setData($name, $value);
            }

            $field->save();
            Mage::getModel('core/session')->addSuccess('Successfully saved field');
        }

        $this->_redirect('adminhtml/custsize/fields');
        return;
    }

    /**
     * Delete a specific field
     */
    protected function deleteField()
    {
        $field = $this->getField();
        $field->delete();
        Mage::getModel('core/session')->addSuccess('Successfully deleted field');

        $this->_redirect('adminhtml/custsize/fields');
        return;
    }

    protected function setFieldId($field_id)
    {
        $this->field_id = $field_id;
    }

    protected function setField($field)
    {
        $this->field = $field;
    }

    protected function getFieldId()
    {
        return $this->field_id;
    }

    protected function getField()
    {
        return $this->field;
    }

    /**
     * Display fieldsets
     *
     */
    public function fieldsetsAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_fieldsets'))
            ->renderLayout();
    }

    /**
     * Perform a fieldset task
     */
    public function fieldsetAction()
    {
        $this->setFieldsetId((int)$this->getRequest()->getParam('fieldset_id', 0));
        $this->setFieldset(Mage::getModel('custsize/profile_fieldset')->load($this->getFieldsetId()));

        $task = $this->getRequest()->getParam('task', null);
        switch($task) {
            case 'save':
                $this->saveFieldset();
                break;
            case 'delete':
                $this->deleteFieldset();
                break;
            case 'edit':
            case 'new':
                $this->editFieldset();
                break;
        }
    }

    /**
     * View a specific fieldset
     */
    protected function viewFieldset()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_fieldset_view'))
            ->renderLayout();
    }

    /**
     * Create a new fieldset or edit a specific fieldset
     */
    protected function editFieldset()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('custsize/admin_fieldset_edit'))
            ->renderLayout();
    }

    /**
     * Save a specific fieldset or a new fieldset
     */
    public function saveFieldset()
    {
        $fieldset = $this->getFieldset();
        if ($this->getRequest()->isPost()) {

            $fieldsetData = $this->getRequest()->getPost('fieldset');
            foreach($fieldsetData as $name => $value) {
                if($name == 'fieldset_id' && empty($value)) continue;
                if($name == 'tag') {
                    if(empty($value)) $value = $fieldsetData['label'];
                    $value = preg_replace('/([^a-z0-9A-Z\-\_\.]+)/', '-', $value);
                    $value = str_replace('--', '-', $value);
                    $value = strtolower($value);
                }
                $fieldset->setData($name, $value);
            }

            $fieldset->save();
            Mage::getModel('core/session')->addSuccess('Successfully saved fieldset');
        }

        $this->_redirect('adminhtml/custsize/fieldsets');
        return;
    }

    /**
     * Delete a specific fieldset
     */
    protected function deleteFieldset()
    {
        $fieldset = $this->getFieldset();
        $fieldset->delete();
        Mage::getModel('core/session')->addSuccess('Successfully deleted fieldset');

        $this->_redirect('adminhtml/custsize/fieldsets');
        return;
    }

    protected function setFieldsetId($fieldset_id)
    {
        $this->fieldset_id = $fieldset_id;
    }

    protected function setFieldset($fieldset)
    {
        $this->fieldset = $fieldset;
    }

    protected function getFieldsetId()
    {
        return $this->fieldset_id;
    }

    protected function getFieldset()
    {
        return $this->fieldset;
    }

    protected function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;
    }

    protected function setProfile($profile)
    {
        $this->profile = $profile;
    }

    protected function getProfileId()
    {
        return $this->profile_id;
    }

    protected function getProfile()
    {
        return $this->profile;
    }

    protected function redirectProfileOverview()
    {
        $customerId = (int)$this->getRequest()->getParam('customer_id', 0);
        if($customerId > 0) {
            $this->_redirect('adminhtml/customer/edit', array('id' => $customerId, 'active_tab' => 'custsize_admin_profiles'));
        } else {
            $this->_redirect('adminhtml/custsize/profiles');
        }
    }
}
