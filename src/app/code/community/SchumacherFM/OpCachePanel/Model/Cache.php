<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
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
        return $this->_getInstance()->recheck();
    }

    /**
     * @todo checkout for disabled modules and do not compile them
     *
     * @return array
     */
    public function compile()
    {
        $baseDir     = Mage::getBaseDir();
        $directories = array(
            $baseDir . DS . 'app' . DS => 0,
            $baseDir . DS . 'lib' . DS => 0,
        );
		$config = $this->getConfiguration();
        $blacklist = $config['blacklist'];

        foreach ($directories as $directory => &$counter) {
            $dir_iterator = new RecursiveDirectoryIterator($directory);
            $iterator     = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
            foreach ($iterator as $file) {
				if ($blacklist) {
                    foreach ($blacklist as $blacklistedEntry) {
                        if (strncmp($file->getPath() . DS . $file->getFilename(), $blacklistedEntry, strlen($blacklistedEntry)) === 0) {
                            continue 2;
                        }
                    }
                }
				
                /** @var $file SplFileInfo */
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $pathToFile = $file->getPath() . DS . $file->getFilename();
                    $ret        = $this->_getInstance()->compile($pathToFile);
                    if ($ret) {
                        ++$counter;
                    }
                }
            }
        }
        return $directories;
    }

    public function getConfiguration()
    {
        return $this->_getInstance()->getConfiguration();
    }

    public function getStatistics()
    {
        return $this->_getInstance()->getStatistics();
    }

    public function getStatus()
    {
        return $this->_getInstance()->getStatus();
    }

    public function isActive()
    {
        return $this->_isOpc() || $this->_isApc();
    }

    public function hasCompiler()
    {
        return $this->_getInstance()->hasCompiler();
    }

    protected function _isApc()
    {
        return (extension_loaded('apc') || extension_loaded('apcu')) && (ini_get('apc.enabled') || ini_get('apc.enabled_cli'));
    }

    protected function _isOpc()
    {
        return extension_loaded('Zend OPcache') && (ini_get('opcache.enable') || ini_get('opcache.enable_cli'));
    }
}
