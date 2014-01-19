<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Model_Types_OpCache extends SchumacherFM_OpCachePanel_Model_Types_AbstractCache
{
    /**
     * @var array
     */
    protected $_compiledFiles = NULL;

    /**
     * @return bool
     */
    public function reset()
    {
        return call_user_func($this->getCachePrefix() . 'reset');
    }

    /**
     * @param string $pathToFile full system path to a php file
     *
     * @return bool|mixed|string
     */
    public function recheck($pathToFile = NULL)
    {
        if (function_exists($this->getCachePrefix() . 'invalidate')) {

            if (NULL !== $pathToFile && is_file($pathToFile)) {
                return call_user_func($this->getCachePrefix() . 'invalidate', $pathToFile);
            }

            $files = call_user_func($this->getCachePrefix() . 'get_status');
            if (!empty($files['scripts'])) {
                foreach ($files['scripts'] as $file => $value) {
                    call_user_func($this->getCachePrefix() . 'invalidate', $file);
                }
            }
            return TRUE;
        } else {
            return 'Sorry, this feature requires Zend Opcache newer than April 8th 2013';
        }
    }

    /**
     * @return array
     */
    protected function _getCompiledFiles()
    {
        if (NULL !== $this->_compiledFiles) {
            return $this->_compiledFiles;
        }
        $status               = opcache_get_status();
        $this->_compiledFiles = $status['scripts'];
        return $this->_compiledFiles;
    }

    /**
     * @param string $pathToFile
     *
     * @return mixed
     */
    public function compile($pathToFile)
    {

        $files = $this->_getCompiledFiles();
        if (isset($files[$pathToFile])) { // work around to avoid a segmentation fault in php binary :-(
            return TRUE;
        }

        return @opcache_compile_file($pathToFile);
    }
}
