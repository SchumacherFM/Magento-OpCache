<?php
/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_Graph extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{

    public function getGraphsDisplay()
    {
        $graphs        = array();
        $colors        = array('green', 'brown', 'red');
        $primes        = array(223, 463, 983, 1979, 3907, 7963, 16229, 32531, 65407, 130987);
        $configuration = call_user_func($this->_cachePrefix . 'get_configuration');
        $status        = call_user_func($this->_cachePrefix . 'get_status');

        $graphs['memory']['total']  = $configuration['directives']['opcache.memory_consumption'];
        $graphs['memory']['free']   = $status['memory_usage']['free_memory'];
        $graphs['memory']['used']   = $status['memory_usage']['used_memory'];
        $graphs['memory']['wasted'] = $status['memory_usage']['wasted_memory'];

        $graphs['keys']['total'] = $status[$this->_cachePrefix . 'statistics']['max_cached_keys'];
        foreach ($primes as $prime) {
            if ($prime >= $graphs['keys']['total']) {
                $graphs['keys']['total'] = $prime;
                break;
            }
        }
        $graphs['keys']['free']    = $graphs['keys']['total'] - $status[$this->_cachePrefix . 'statistics']['num_cached_keys'];
        $graphs['keys']['scripts'] = $status[$this->_cachePrefix . 'statistics']['num_cached_scripts'];
        $graphs['keys']['wasted']  = $status[$this->_cachePrefix . 'statistics']['num_cached_keys'] - $status[$this->_cachePrefix . 'statistics']['num_cached_scripts'];

        $graphs['hits']['total']     = 0;
        $graphs['hits']['hits']      = $status[$this->_cachePrefix . 'statistics']['hits'];
        $graphs['hits']['misses']    = $status[$this->_cachePrefix . 'statistics']['misses'];
        $graphs['hits']['blacklist'] = $status[$this->_cachePrefix . 'statistics']['blacklist_misses'];
        $graphs['hits']['total']     = array_sum($graphs['hits']);

        $graphs['restarts']['total']  = 0;
        $graphs['restarts']['manual'] = $status[$this->_cachePrefix . 'statistics']['manual_restarts'];
        $graphs['restarts']['keys']   = $status[$this->_cachePrefix . 'statistics']['hash_restarts'];
        $graphs['restarts']['memory'] = $status[$this->_cachePrefix . 'statistics']['oom_restarts'];
        $graphs['restarts']['total']  = array_sum($graphs['restarts']);

        $return = [];
        foreach ($graphs as $caption => $graph) {
            $return[] = '<div class="graph"><div class="pheader">' . $caption . '</div><table border="0" cellpadding="0" cellspacing="0">';
            foreach ($graph as $label => $value) {
                $total = FALSE;
                if ($label == 'total') {
                    $key          = 0;
                    $total        = $value;
                    $totalDisplay = '<td rowspan="3" class="total"><span>' . ($total > 999999 ? round($total / 1024 / 1024) . 'M' : ($total > 9999 ? round($total / 1024) . 'K' : $total)) . '</span><div></div></td>';
                    continue;
                }
                $percent  = $total ? floor($value * 100 / $total) : ''; // @todo bug
                $percent  = (!$percent || $percent > 99) ? '' : $percent . '%';
                Zend_Debug::dump($percent);

                $return[] = '<tr>' . $totalDisplay . '<td class="actual">' . ($value > 999999 ? round($value / 1024 / 1024) . 'M' : ($value > 9999 ? round
                        ($value / 1024) . 'K' : $value)) . '</td><td class="bar ' . $colors[$key] . '" height="' . $percent . '">' . $percent . '</td><td>' . $label .
                    '</td></tr>';
                $key++;
                $totalDisplay = '';
            }
            $return[] = '</table></div>' . "\n";
        }
        return implode(PHP_EOL, $return);
    }
}
