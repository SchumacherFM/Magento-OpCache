<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_Unloaded extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{
    protected function _toHtml()
    {
        if (true === Mage::getSingleton('opcache/cache')->isActive()) {
            return '';
        }
        return parent::_toHtml();
    }

    public function _construct()
    {
        parent::_construct();
        $this->setTitle(Mage::helper('opcache')->__('OpCache Panel not loaded'));
    }
}
