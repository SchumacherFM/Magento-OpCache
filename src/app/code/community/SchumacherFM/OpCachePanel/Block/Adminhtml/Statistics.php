<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_Statistics extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{

    public function getStatisticsDisplay()
    {
        $return = array();
        $status = $this->_getStatus();
        if (FALSE !== $status) {

            unset($status[$this->_cachePrefix . 'statistics']['start_time'], $status[$this->_cachePrefix . 'statistics']['last_restart_time']);
            $return[] = $this->_printTable($status[$this->_cachePrefix . 'statistics']);
        }

        return implode(PHP_EOL, $return);
    }
}
