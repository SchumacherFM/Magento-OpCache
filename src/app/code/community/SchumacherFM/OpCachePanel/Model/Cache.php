<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Model_Cache
{

    /**
     * @var SchumacherFM_OpCachePanel_Model_Types_AbstractCache
     */
    protected $_instance = NULL;

    protected function _getInstance()
    {

        if (NULL !== $this->_instance) {
            return $this->_instance;
        }
        if ($this->_isApc()) {
            $this->_instance = Mage::getModel('opcache/types_apc');
        }
        if ($this->_isOpc()) {
            $this->_instance = Mage::getModel('opcache/types_opCache');
        }

        return $this->_instance;
    }

    public function reset()
    {
        return $this->_getInstance()->reset();
    }

    public function recheck()
    {
    }

    protected function _isApc()
    {
        return extension_loaded('apc') && (ini_get('apc.enabled') || ini_get('apc.enabled_cli'));
    }

    protected function _isOpc()
    {
        return extension_loaded('Zend OPcache') && (ini_get('opcache.enable') || ini_get('opcache.enable_cli'));
    }
}
