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
        $colors = array('green', 'brown', 'red');
        $graphs = Mage::getModel('opcache/cache')->getStatistics();
        $return = array();
        foreach ($graphs as $caption => $graph) {
            $return[] = '<div class="graph"><div class="pheader">' . $caption . '</div><table border="0" cellpadding="0" cellspacing="0">';
            $total    = FALSE;
            foreach ($graph as $label => $value) {
                if ($label === 'total') {
                    $key          = 0;
                    $total        = $value;
                    $totalDisplay = '<td rowspan="3" class="total"><span>' . ($caption === 'memory' ? $this->_formatBytes($total) : $total) .
                        '</span><div></div></td>';
                    continue;
                }
                $percent = $total ? floor($value * 100 / $total) : '';
                $percent = (!$percent || $percent > 99) ? '' : $percent . '%';

                $return[] = '<tr>' . $totalDisplay . '<td class="actual">' . (
                    $caption === 'memory' ? $this->_formatBytes($value) : $value
                    ) . '</td><td class="bar ' . $colors[$key] . '" height="' . $percent . '">' . $percent . '</td><td>' . $label . '</td></tr>';
                $key++;
                $totalDisplay = '';
            }
            $return[] = '</table></div>' . "\n";
        }
        return implode(PHP_EOL, $return);
    }
}
