<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Model_Types_Apc extends SchumacherFM_OpCachePanel_Model_Types_AbstractCache
{

    /**
     * resets the cache
     *
     * @return mixed
     */
    public function reset()
    {
        $a = apc_clear_cache();
        $b = apc_clear_cache('user');
        return $a && $b;
    }

    /**
     * rechecks the cache, if file is provide then only that file otherwise everything
     *
     * @param null $pathToFile
     *
     * @return mixed
     */
    public function recheck($pathToFile = NULL)
    {
        return FALSE;
    }

    /**
     * compiles all files or one file
     *
     * @param string $pathToFile
     *
     * @return boolean
     */
    public function compile($pathToFile)
    {
        return apc_compile_file($pathToFile);
    }

    /**
     * checks if there is an compiler to preload all files into the cache
     *
     * @return boolean
     */
    public function hasCompiler()
    {
        return function_exists('apc_compile_file');
    }

    public function getConfiguration()
    {
        $info = apc_cache_info();

        return array_merge($info, array(
            'blacklist' => ''
        ));
    }

    public function getStatistics()
    {
        return array();
    }

    public function getStatus()
    {
        return FALSE; // apc_cache_info();
    }
}
