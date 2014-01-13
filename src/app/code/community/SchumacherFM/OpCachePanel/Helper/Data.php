<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @return bool|string
     */
    public function getApiKeyName()
    {
        $return = Mage::getStoreConfig('system/opcachepanel/api_key_name');
        return preg_match('~^[a-z0-9]{32}$~i', $return) !== 1 ? FALSE : $return;
    }

    /**
     * @return bool|string
     */
    public function getApiKey()
    {
        $return = Mage::getStoreConfig('system/opcachepanel/api_key');
        $retlen = strlen($return);
        $unique = array();

        $doubles = 0;
        for ($i = 0; $i < $retlen; $i++) {
            $char = trim($return[$i]);
            if (!isset($unique[$char])) {
                $unique[$char] = 1;
            } else {
                $unique[$char]++;
                $doubles++;
            }
        }

        return count($unique) < 32 || $doubles !== 0 ? FALSE : $return;
    }

    /**
     * @param Mage_Core_Controller_Request_Http $request
     *
     * @return bool
     */
    public function isApiKeyValid(Mage_Core_Controller_Request_Http $request)
    {
        $apiKeyName = $this->getApiKeyName();
        $postApiKey = $request->getParam($apiKeyName, NULL);

        $key = $this->getApiKey();
        return !empty($key) && $key === $postApiKey;
    }
}