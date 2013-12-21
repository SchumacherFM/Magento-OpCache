<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Model_Options_Engine
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'php', 'label' => Mage::helper('pgp')->__('PHP based')),
            array('value' => 'cli', 'label' => Mage::helper('pgp')->__('GPG native binaries')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'php' => Mage::helper('pgp')->__('PHP based'),
            'cli' => Mage::helper('pgp')->__('GPG native binaries'),
        );
    }

}
