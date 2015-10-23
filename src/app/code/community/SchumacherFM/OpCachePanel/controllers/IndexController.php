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
        $isKeyValid = Mage::helper('opcache')->isApiKeyValid($this->getRequest());

        if (!$this->getRequest()->isPost() || TRUE !== $isKeyValid) {
            return $this->_forward('defaultNoRoute');
        }

        Mage::getModel('opcache/cache')->reset();
        $this->getResponse()->setBody('Ok');
    }
}
