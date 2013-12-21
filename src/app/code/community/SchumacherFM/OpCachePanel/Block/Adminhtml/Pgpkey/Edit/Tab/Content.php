<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Block_Adminhtml_Pgpkey_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare content for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('pgp')->__('PGP Key');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return TRUE;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return FALSE;
    }

    /**
     * Prepare Content Tab form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('pgpkey_content_');

        $fieldsetHtmlClass = 'fieldset-wide';

        $model = Mage::registry('current_pubkeys');

        // add default content fieldset
        $fieldset = $form->addFieldset('default_fieldset', array(
            'legend' => Mage::helper('pgp')->__('The PGP Key - Key ID and Email will be extracted from the key.'),
            'class'  => $fieldsetHtmlClass,
        ));

        $fieldset->addField('key_id', 'text',
            array(
                'name'     => 'key_id',
                'label'    => Mage::helper('pgp')->__('Key ID'),
                'title'    => Mage::helper('pgp')->__('Key ID'),
                'readonly' => TRUE
            ));

        $fieldset->addField('email', 'text',
            array(

                'name'     => 'email',
                'label'    => Mage::helper('pgp')->__('Email Address'),
                'title'    => Mage::helper('pgp')->__('Email Address'),
                'readonly' => TRUE
            ));

        $fieldset->addField('public_key', 'textarea',
            array(

                'name'     => 'public_key',
                'label'    => Mage::helper('pgp')->__('Public Key'),
                'title'    => Mage::helper('pgp')->__('Public Key'),
//                'format'   => Mage::app()->getLocale()
//                    ->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'required' => FALSE
            ));

        $fieldset->addField('public_key_file', 'file', array(
            'name'               => 'public_key_file',
            'label'              => Mage::helper('pgp')->__('Public Key File Upload'),
            'id'                 => 'public_key',
            'title'              => Mage::helper('pgp')->__('Public Key File Upload'),
            'required'           => FALSE,
            'after_element_html' => Mage::helper('pgp')->__('<br>... or upload as text file.')
        ));

        if ($model) {
            $form->setValues($model->getData());
        }
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
