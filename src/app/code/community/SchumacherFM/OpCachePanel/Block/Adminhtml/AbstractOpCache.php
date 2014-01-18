<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache extends Mage_Adminhtml_Block_Widget
{
    protected $_cachePrefix = '';

    public function _construct()
    {
        $this->_cachePrefix = function_exists('opcache_reset') ? 'opcache_' : (function_exists('accelerator_reset') ? 'accelerator_' : '');
        parent::_construct();
    }

    /**
     * @return bool|mixed
     */
    protected function _getStatus()
    {
        if (function_exists($this->_cachePrefix . 'get_status')) {
            return call_user_func($this->_cachePrefix . 'get_status');
        }
        return FALSE;
    }

    /**
     * @todo use singelton as this is maybe needed in other block, also cache that output
     * @return mixed
     */
    protected function _getOpCacheInfo()
    {

        ob_start();
        phpinfo(8);
        $phpinfo = ob_get_contents();
        ob_end_clean(); // some info is only available via phpinfo? sadly buffering capture has to be used
        if (!preg_match('/module\_Zend (Optimizer\+|OPcache).+?(\<table[^>]*\>.+?\<\/table\>).+?(\<table[^>]*\>.+?\<\/table\>)/s', $phpinfo, $opcache)) {
        } // todo
        return $opcache;
    }

    protected function _printTable($array, $headers = FALSE)
    {
        if (empty($array) || !is_array($array)) {
            return '';
        }
        $return   = array();
        $return[] = '<table border="0" cellpadding="3" width="100%">';
        if (!empty($headers)) {
            if (!is_array($headers)) {
                $headers = array_keys(reset($array));
            }
            $return[] = '<tr class="pheader">';
            foreach ($headers as $value) {
                $return[] = '<th>' . $value . '</th>';
            }
            $return[] = '</tr>';
        }
        foreach ($array as $key => $value) {
            $return[] = '<tr>';
            if (!is_numeric($key)) {
                $key      = ucwords(str_replace('_', ' ', $key));
                $return[] = '<td class="e">' . $key . '</td>';
                if (is_numeric($value)) {
                    if ($value > 1048576) {
                        $value = round($value / 1048576, 1) . 'M';
                    } elseif (is_float($value)) {
                        $value = round($value, 1);
                    }
                }
            }
            if (is_array($value)) {
                foreach ($value as $column) {
                    $return[] = '<td class="v">' . $column . '</td>';
                }
                echo '</tr>';
            } else {
                $return[] = '<td class="v">' . $value . '</td></tr>';
            }
        }
        $return[] = '</table>';
        return implode(PHP_EOL, $return);
    }

    /**
     * @param int $size
     * @param int $precision
     *
     * @return string
     */
    protected function _formatBytes($size, $precision = 2)
    {
        $base     = log($size) / log(1024);
        $suffixes = array('', 'k', 'M', 'G', 'T');
        $fbase    = floor($base);

        return isset($suffixes[$fbase]) ? round(pow(1024, $base - $fbase), $precision) . $suffixes[$fbase] : '';
    }

    /**
     * @param   int   $time
     * @param     int $original
     * @param int     $extended
     * @param string  $text
     *
     * @return string
     */
    protected function _timeSince($time, $original, $extended = 0, $text = 'ago')
    {
        $time   = $time - $original;
        $day    = $extended ? floor($time / 86400) : round($time / 86400, 0);
        $amount = 0;
        $unit   = '';
        if ($time < 86400) {
            if ($time < 60) {
                $amount = $time;
                $unit   = 'second';
            } elseif ($time < 3600) {
                $amount = floor($time / 60);
                $unit   = 'minute';
            } else {
                $amount = floor($time / 3600);
                $unit   = 'hour';
            }
        } elseif ($day < 14) {
            $amount = $day;
            $unit   = 'day';
        } elseif ($day < 56) {
            $amount = floor($day / 7);
            $unit   = 'week';
        } elseif ($day < 672) {
            $amount = floor($day / 30);
            $unit   = 'month';
        } else {
            $amount = intval(2 * ($day / 365)) / 2;
            $unit   = 'year';
        }

        if ($amount != 1) {
            $unit .= 's';
        }
        if ($extended && $time > 60) {
            $text = ' and ' . $this->_timeSince($time, $time < 86400 ? ($time < 3600 ? $amount * 60 : $amount * 3600) : $day * 86400, 0, '') . $text;
        }

        return $amount . ' ' . $unit . ' ' . $text;
    }
}
