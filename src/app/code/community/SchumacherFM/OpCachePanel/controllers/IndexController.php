<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Controller
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $apiKeyName = Mage::helper('opcache')->getApiKeyName();
        $postApiKey = $this->getRequest()->getParam($apiKeyName, NULL);
        $isKeyValid = Mage::helper('opcache')->isApiKeyValid($postApiKey);

        if (!$this->getRequest()->isPost() || FALSE === $apiKeyName || TRUE !== $isKeyValid) {
            $this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
            $this->getResponse()->setHeader('Status', '404 File not found');
            $this->getResponse()->setBody('Status: 404 File not found');
            $this->getResponse()->sendResponse();
            exit;
        }

        Mage::getModel('opcache/cache')->reset();
        $this->getResponse()->setBody('Ok');
    }
}
