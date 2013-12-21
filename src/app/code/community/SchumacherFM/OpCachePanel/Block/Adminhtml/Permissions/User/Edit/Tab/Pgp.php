<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Block_Adminhtml_Permissions_User_Edit_Tab_Pgp extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('pgp_');

        Mage::getModel('pgp/options_publicKeyForm')->injectFieldSet($form);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('PGP Public Key');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('PGP Public Key');
    }

    /**
     * Returns status flag about this tab can be shown or not
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
}
