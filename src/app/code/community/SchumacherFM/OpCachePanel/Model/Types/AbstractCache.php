<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class SchumacherFM_OpCachePanel_Model_Types_AbstractCache
{
    private $_cachePrefix = NULL;

    /**
     * @return string
     */
    public function getCachePrefix()
    {
        if (NULL !== $this->_cachePrefix) {
            return $this->_cachePrefix;
        }
        $this->_cachePrefix = function_exists('opcache_reset') ? 'opcache_' : (function_exists('accelerator_reset') ? 'accelerator_' : '');
        return $this->_cachePrefix;
    }

    /**
     * resets the cache
     *
     * @return mixed
     */
    public abstract function reset();

    /**
     * rechecks the cache, if file is provide then only that file otherwise everything
     *
     * @param null $pathToFile
     *
     * @return mixed
     */
    public abstract function recheck($pathToFile = NULL);

    /**
     * compiles all files or one file
     *
     * @param string $pathToFile
     *
     * @return boolean
     */
    public abstract function compile($pathToFile);

    /**
     * checks if there is an compiler to preload all files into the cache
     *
     * @return boolean
     */
    public abstract function hasCompiler();

    public abstract function getConfiguration();

    public abstract function getStatistics();

    public abstract function getStatus();
}
