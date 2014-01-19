<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_Functions extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{

    public function getFunctionsDisplay()
    {
        $return = array();

        $name      = 'zend opcache';
        $functions = get_extension_funcs($name);
        if (!$functions) {
            $name      = 'zend optimizer+';
            $functions = get_extension_funcs($name);
        }
        if ($functions) {
            $return[] = $this->_printTable($functions);
        }

        return implode(PHP_EOL, $return);
    }
}
