<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_Blacklist extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{

    public function getBlacklistDisplay()
    {
        $return        = array();
        $configuration = $this->_getConfiguration();
        if (FALSE !== $configuration) {
            $return[] = $this->_printTable($configuration['blacklist']);
        }
        return implode(PHP_EOL, $return);
    }
}
