<?php
/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_General extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{

    public function getGeneralDisplay()
    {
        $configuration = call_user_func($this->_cachePrefix . 'get_configuration');
        $host          = function_exists('gethostname') ? @gethostname() : @php_uname('n');
        if (empty($host)) {
            $host = empty($_SERVER['SERVER_NAME']) ? $_SERVER['HOST_NAME'] : $_SERVER['SERVER_NAME'];
        }
        $version                    = array('Host' => $host);
        $version['PHP Version']     = 'PHP ' . (defined('PHP_VERSION') ? PHP_VERSION : '???') . ' ' . (defined('PHP_SAPI') ? PHP_SAPI : '') . ' ' . (defined('PHP_OS') ? ' ' . PHP_OS : '');
        $version['Opcache Version'] = empty($configuration['version']['version']) ? '???' : $configuration['version'][$this->_cachePrefix . 'product_name'] . ' ' .
            $configuration['version']['version'];
        $return                     = [$this->_printTable($version)];

        $opcache = $this->_getOpCacheInfo();
        if (!empty($opcache[2])) {
            $return[] = preg_replace('/\<tr\>\<td class\="e"\>[^>]+\<\/td\>\<td class\="v"\>[0-9\,\. ]+\<\/td\>\<\/tr\>/', '', $opcache[2]);
        }

        return implode(PHP_EOL, $return);
    }
}
