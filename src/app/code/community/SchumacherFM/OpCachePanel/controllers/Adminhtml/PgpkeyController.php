<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Controller
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Adminhtml_PgpkeyController extends Mage_Adminhtml_Controller_Action
{
    /**
     * key list
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('PGP Keys'));

        $this->loadLayout();
        $this->_setActiveMenu('system/pgp');
        $this->renderLayout();
    }

    /**
     * Create new pgp key
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit action
     *
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var SchumacherFM_Pgp_Model_Pubkeys $model */
        $model = $this->_initPubkeys();
        if (!$model->getId() && $id) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pgp')->__('This pgp key no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New PGP Key'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
        if (!empty($data)) {
            $model->addData($data);
        }

        $this->loadLayout();
        $this->_setActiveMenu('system/pgp');
        $this->_addBreadcrumb($id ? Mage::helper('pgp')->__('Edit PGP Key') : Mage::helper('pgp')->__('New PGP Key'),
            $id ? Mage::helper('pgp')->__('Edit PGP Key') : Mage::helper('pgp')->__('New PGP Key'))
            ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', FALSE);
        if ($data = $this->getRequest()->getPost()) {

            /** @var SchumacherFM_Pgp_Model_Pubkeys $model */
            $model = $this->_initPubkeys('key_id');

            if (isset($_FILES['public_key_file']) && isset($_FILES['public_key_file']['name']) && !empty($_FILES['public_key_file']['name'])) {

                $fileName = $_FILES['public_key_file']['name'];

                if (!Mage::helper('pgp')->isAllowedUploadedFile($fileName)) {
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('pgp')->__('Disallowed file extension! Only asc, txt and pub are supported.')
                    );
                    $this->_redirect('*/*/');
                    return;
                }

                $data['public_key'] = file_get_contents($_FILES['public_key_file']['tmp_name']);
                if (empty($data['public_key'])) {
                    throw new Exception('Failed to load public key from tmp_name...');
                }
            }

            /**
             * extract key id and email address from pub key ...
             */
            if (!$model->getCreatedAt() || strstr($model->getCreatedAt(), '0000') !== FALSE) {
                $model->setCreatedAt(date('Y-m-d H:i:s'));
            }

            // save model
            $data = $this->_getPkDetails($data);
            try {
                if (!empty($data)) {
                    $model->addData($data);
                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                }
                $model->save();
                Mage::getSingleton('adminhtml/session')->setFormData(FALSE);
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pgp')->__('The PGP Key has been saved.'));
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = TRUE;
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('pgp')->__('Unable to save the PGP Key.'));
                $redirectBack = TRUE;
                Mage::logException($e);
            }
            if ($redirectBack) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function _getPkDetails(array $data)
    {

        /** @var SchumacherFM_Pgp_Model_Pgp $pgp */
        $pgp = Mage::getModel('pgp/pgp', array(
            'publicKeyAscii' => $data['public_key'],
            'engine'         => null,
        ));

        $pgpDetails = $pgp->getPublicKeyDetails();

        $data['key_id'] = $pgpDetails['id'];
        $data['email']  = $pgpDetails['usr'];
        return $data;
    }

    /**
     * Delete action
     *
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('pgp/pubkeys');
                $model->load($id);
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pgp')->__('The PGP Key has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('pgp')->__('An error occurred while deleting PGP Key data. Please review log and try again.'));
                Mage::logException($e);
                // save data in session
                // redirect to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pgp')->__('Unable to find a PGP Key to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Delete specified keys using grid massaction
     *
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('pgpkey');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select PGP Keys(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('pgp/pubkeys')->load($id);
                    $model->delete();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('pgp')->__('An error occurred while mass deleting PGP Keys. Please review log and try again.'));
                Mage::logException($e);
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Load from request
     *
     * @param string $idFieldName
     *
     * @return SchumacherFM_Pgp_Model_Pubkeys $model
     */
    protected function _initPubkeys($idFieldName = 'id')
    {
        $this->_title($this->__('System'))->_title($this->__('PGP Keys'));

        $id    = $this->getRequest()->getParam($idFieldName);
        $model = Mage::getModel('pgp/pubkeys');
        if ($id) {
            $model->load($id);
        }
        if (!Mage::registry('current_pubkeys')) {
            Mage::register('current_pubkeys', $model);
        }
        return $model;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/pgp');
    }

    /**
     * Render grid
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

}
