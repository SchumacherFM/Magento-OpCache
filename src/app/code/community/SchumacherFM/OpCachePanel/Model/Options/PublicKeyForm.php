<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Model_Options_PublicKeyForm
{

    /**
     * @param Varien_Data_Form $form
     *
     * @return $this
     */
    public function injectFieldSet(Varien_Data_Form $form)
    {

        $form->setEnctype('multipart/form-data');

        $fieldSet = $form->addFieldset('pgp_fieldset', array('legend' => Mage::helper('adminhtml')->__('PGP Public Key')));

        $fieldSet->addField('key_id', 'text', array(
            'name'     => 'key_id',
            'label'    => Mage::helper('pgp')->__('Public Sub Key ID'),
            'id'       => 'key_id',
            'title'    => Mage::helper('pgp')->__('Public Sub Key ID'),
            'disabled' => TRUE,

        ));

        $fieldSet->addField('public_key', 'textarea', array(
            'name'               => 'public_key',
            'label'              => Mage::helper('pgp')->__('Public Key'),
            'id'                 => 'public_key',
            'title'              => Mage::helper('pgp')->__('Public Key'),
            'required'           => FALSE,
            'after_element_html' => Mage::helper('pgp')->__('Must belong to the users email address. No comments inside the key.')
        ));

        $fieldSet->addField('public_key_file', 'file', array(
            'name'               => 'public_key_file',
            'label'              => Mage::helper('pgp')->__('Public Key File Upload'),
            'id'                 => 'public_key',
            'title'              => Mage::helper('pgp')->__('Public Key File Upload'),
            'required'           => FALSE,
            'after_element_html' => Mage::helper('pgp')->__('<br>... or upload as text file.')
        ));

        $form->addValues($this->_getPublicKey()->getData());

        return $this;
    }

    /**
     * @return Mage_Core_Model_Abstract
     */
    protected function _getPublicKey()
    {
        $model = Mage::registry('permissions_user');

        if (!$model instanceof Mage_Admin_Model_User) {
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();
            $user   = Mage::getModel('admin/user')->load($userId);
            $user->unsetData('password');
            $email = $user->getEmail();
            $user  = NULL;
        } else {
            $email = $model->getEmail();
        }

        return Mage::getModel('pgp/pubkeys')->load($email, 'email');
    }
}
