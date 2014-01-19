<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_Runtime extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{

    public function getRuntimeDisplay()
    {
        $opcache = $this->_getOpCacheInfo();
        return isset($opcache[3]) ? $opcache[3] : '';
    }
}
