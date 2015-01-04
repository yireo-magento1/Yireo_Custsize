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
 * Custsize controller for the frontend
 */
class Yireo_Custsize_IndexController extends Mage_Core_Controller_Front_Action
{
    /*
     * Current profile ID
     */
    protected $_profile_id = 0;

    /*
     * Current profile
     */
    protected $_profile = null;

    /**
     * Display profiles of this customer
     *
     */
    public function profilesAction()
    {
        if ($this->_getSession()->isLoggedIn() == false) {
            $this->_getSession()->addError($this->__('You need to login'));
            $this->_redirect('customer/account/login');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Perform a profile task
     */
    public function profileAction()
    {
        $this->_profile_id = (int)$this->getRequest()->getParam('profile_id', 0);
        $this->_profile = Mage::getModel('custsize/profile')->load($this->_profile_id);
        $task = $this->getRequest()->getParam('task', null);

        if($this->checkAccess($this->_profile_id, $task) == false) {
            $this->_redirect('custsize/index/profiles');
            return;
        }

        switch($task) {
            case 'delete':
                $this->deleteProfile();
                break;
            case 'confirmdelete':
                $this->confirmdeleteProfile();
                break;
            case 'edit':
            case 'new':
                $this->editProfile();
                break;
            case 'save':
                $this->saveProfile();
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
        $this->loadLayout(array('default', 'custsize_index_profile_confirmdelete'));
        $this->renderLayout();
    }

    /**
     * View a specific profile
     */
    protected function viewProfile()
    {
        $this->loadLayout(array('default', 'custsize_index_profile_view'));
        $this->renderLayout();
    }

    /**
     * Create a new profile or edit a specific profile
     */
    protected function editProfile()
    {
        $this->loadLayout(array('default', 'custsize_index_profile_edit'));
        $this->renderLayout();
    }

    /**
     * Save a specific profile or a new profile
     */
    protected function saveProfile()
    {
        $profile = $this->_profile;
        if ($this->getRequest()->isPost()) {

            // Fetch the POST-data
            $profileData = $this->getRequest()->getPost('profile');
            $fieldData = $this->getRequest()->getPost('field');

            // Make sure the required fields are not empty
            $pass = true;
            if(empty($profileData['name'])) {
                Mage::getModel('core/session')->addError('Name is required');
                $pass = false;
            }

            if(!empty($fieldData)) {
                foreach($fieldData as $fieldId => $fieldValue) {
                    $field = Mage::getModel('custsize/profile_field')->load($fieldId);
                    if($field->getData('required') == 1 && empty($fieldValue)) {
                        Mage::getModel('core/session')->addError(Mage::helper('custsize')->__('%s is required', $field->getLabel()));
                        $pass = false;
                    }
                }
            }

            if($pass == false) {
                $id = $this->_profile_id;
                if($id > 0) {
                    $this->_redirect('custsize/index/profile', array('task' => 'edit', 'profile_id' => $id));
                } else {
                    $this->_redirect('custsize/index/profile', array('task' => 'new'));
                }
                return;
            }

            // Complete the profile
            $profile->setData('name', $profileData['name']);
            $profile->setData('description', $profileData['description']);
            $profile->setData('default', (isset($profileData['default'])) ? $profileData['default'] : 0);
            $profile->setData('customer_id', $this->_getSession()->getCustomerId());

            // Save this profile
            try {
                $profile->save();
            } catch(Exception $e) {
                Mage::getModel('core/session')->addError($e->getMessage());
                $this->_redirect('custsize/index/profiles');
                return;
            }

            // Save the fields belonging to this profile
            $rs = $profile->saveFields($fieldData, $profile->getProfileId());

            if($rs == true) {
                Mage::getModel('core/session')->addSuccess('Successfully saved profile');
            } else {
                Mage::getModel('core/session')->addWarning('Successfully saved profile, but failed to save extra values');
            }
        }

        $this->_redirect('custsize/index/profiles');
        return;
    }

    /**
     * Delete a specific profile
     */
    protected function deleteProfile()
    {
        $profile = $this->_profile;
        if ($this->getRequest()->isPost()) {
            $profile->delete();
            Mage::getModel('core/session')->addSuccess('Successfully deleted profile');
        }

        $this->_redirect('custsize/index/profiles');
        return;
    }

    /*
     * Check if this profile is owned by this customer
     */
    protected function checkAccess($profile_id = 0, $task = null)
    {
        if ($this->_getSession()->isLoggedIn() == false) {
            $this->_getSession()->addError($this->__('You need to login'));
            return false;
        }

        if($profile_id == 0 && in_array($task, array('new', 'save'))) {
            return true;
        }

        $profile = Mage::getModel('custsize/profile')->load($profile_id);
        if(empty($profile) && $profile_id > 0) {
            $this->_getSession()->addError($this->__('Empty request'));
            return false;

        } elseif($profile->getCustomerId() != $this->_getSession()->getCustomerId()) {
            $this->_getSession()->addError($this->__('Access denied: '.$profile_id));
            return false;
        }

        return true;
    }

    /*
     * Helper-method to get the current customer-session
     */
    protected function _getSession()
    {
        return Mage::getModel('customer/session');
    }
}
