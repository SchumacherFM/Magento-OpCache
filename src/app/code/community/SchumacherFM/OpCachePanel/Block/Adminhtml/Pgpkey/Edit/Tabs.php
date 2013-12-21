<?php
/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_OpCachePanelkey_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize edit page tabs
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('pgpkey_info_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('pgp')->__('PGP Key Information'));
    }
}
