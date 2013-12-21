<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Block_Adminhtml_Pgpkey_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize edit page. Set management buttons
     *
     */
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_controller = 'adminhtml_pgpkey';
        $this->_blockGroup = 'pgp';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('pgp')->__('Save PGP Key'));
        $this->_updateButton('delete', 'label', Mage::helper('pgp')->__('Delete PGP Key'));

    }

    /**
     * Get header text for banenr edit page
     *
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_pubkeys')->getId()) {
            return $this->escapeHtml(Mage::registry('current_pubkeys')->getEmail());
        } else {
            return Mage::helper('pgp')->__('New PGP Key');
        }
    }

    /**
     * Get form action URL
     *
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save');
    }
}
