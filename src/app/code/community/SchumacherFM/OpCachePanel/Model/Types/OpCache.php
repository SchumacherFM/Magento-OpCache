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
    protected $_blackList = null;

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
     * @return array
     */
    protected function _getBlackList()
    {
        if (NULL !== $this->_blackList) {
            return $this->_blackList;
        }

        $config = opcache_get_configuration();

        $this->_getBlackList = $config['blacklist'];

        return $this->_blackList;
    }
    
    /**
     * @param string $pathToFile
     *
     * @return boolean
     */
    public function compile($pathToFile)
    {

        $files = $this->_getCompiledFiles();
        $blackList = $this->_getBlackList();
        if (isset($files[$pathToFile]) || in_array($pathToFile, $blackList)) { // work around to avoid a segmentation fault in php binary  and skip files in opCache black list
            return TRUE;
        }

        return @opcache_compile_file($pathToFile);
    }

    /**
     * @return bool
     */
    public function hasCompiler()
    {
        return function_exists('opcache_compile_file');
    }

    /**
     * @return bool|array
     */
    public function getConfiguration()
    {
        $configuration = FALSE;
        if (function_exists($this->getCachePrefix() . 'get_configuration')) {
            $configuration = call_user_func($this->getCachePrefix() . 'get_configuration');
        }
        return $configuration;
    }

    public function getStatus(){

        if (function_exists($this->getCachePrefix() . 'get_status')) {
            return call_user_func($this->getCachePrefix() . 'get_status');
        }
        return FALSE;
    }

    /**
     *
     */
    public function getStatistics()
    {
        $graphs        = array();
        $primes        = array(223, 463, 983, 1979, 3907, 7963, 16229, 32531, 65407, 130987);
        $configuration = $this->getConfiguration();
        $status        = opcache_get_status();

        $graphs['memory']['total']  = $configuration['directives']['opcache.memory_consumption'];
        $graphs['memory']['free']   = $status['memory_usage']['free_memory'];
        $graphs['memory']['used']   = $status['memory_usage']['used_memory'];
        $graphs['memory']['wasted'] = $status['memory_usage']['wasted_memory'];

        $graphs['keys']['total'] = $status[$this->getCachePrefix() . 'statistics']['max_cached_keys'];
        foreach ($primes as $prime) {
            if ($prime >= $graphs['keys']['total']) {
                $graphs['keys']['total'] = $prime;
                break;
            }
        }
        $graphs['keys']['free']    = $graphs['keys']['total'] - $status[$this->getCachePrefix() . 'statistics']['num_cached_keys'];
        $graphs['keys']['scripts'] = $status[$this->getCachePrefix() . 'statistics']['num_cached_scripts'];
        $graphs['keys']['wasted']  = $status[$this->getCachePrefix() . 'statistics']['num_cached_keys'] - $status[$this->getCachePrefix() . 'statistics']['num_cached_scripts'];

        $graphs['hits']['total']     = 0;
        $graphs['hits']['hits']      = $status[$this->getCachePrefix() . 'statistics']['hits'];
        $graphs['hits']['misses']    = $status[$this->getCachePrefix() . 'statistics']['misses'];
        $graphs['hits']['blacklist'] = $status[$this->getCachePrefix() . 'statistics']['blacklist_misses'];
        $graphs['hits']['total']     = array_sum($graphs['hits']);

        $graphs['restarts']['total']  = 0;
        $graphs['restarts']['manual'] = $status[$this->getCachePrefix() . 'statistics']['manual_restarts'];
        $graphs['restarts']['keys']   = $status[$this->getCachePrefix() . 'statistics']['hash_restarts'];
        $graphs['restarts']['memory'] = $status[$this->getCachePrefix() . 'statistics']['oom_restarts'];
        $graphs['restarts']['total']  = array_sum($graphs['restarts']);
        return $graphs;
    }
}
