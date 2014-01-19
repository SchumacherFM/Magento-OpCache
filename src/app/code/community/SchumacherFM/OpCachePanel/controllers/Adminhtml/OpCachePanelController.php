<?php

/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Controller
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @todo        fighting DRY
 */
class SchumacherFM_OpCachePanel_Adminhtml_OpCachePanelController extends Mage_Adminhtml_Controller_Action
{
    /**
     * key list
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('OpCache Panel'));
        $this->loadLayout();
        $this->_setActiveMenu('system/opcache');
        $this->renderLayout();
    }

    public function resetAction()
    {
        $result = Mage::getModel('opcache/cache')->reset();
        if ($result === TRUE) {
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('opcache')->__('Reset cache successful!'));
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('opcache')->__('Reset cache failed!'));
        }
        $this->_redirect('*/opCachePanel');
    }

    public function recheckAction()
    {
        $result = Mage::getModel('opcache/cache')->recheck();
        if ($result === TRUE) {
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('opcache')->__('Recheck cache successful!'));
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('opcache')->__('Recheck cache failed: ' . $result));
        }
        $this->_redirect('*/opCachePanel');
    }

    public function compileAction()
    {
        $result = Mage::getModel('opcache/cache')->compile();

        $msg = array();
        foreach ($result as $directory => $compiledFiles) {
            $msg[] = $directory . ': ' . $compiledFiles . ' php files';
        }

        Mage::getSingleton('adminhtml/session')->addSuccess(
            Mage::helper('opcache')->__('Compiled files:' . PHP_EOL . '%s', implode(PHP_EOL, $msg))
        );

        $this->_redirect('*/opCachePanel');
    }

    public function graphDataJsonAction()
    {
        $stat = Mage::getModel('opcache/cache')->getStatistics();

        $this->getResponse()->setHeader('Content-type', 'application/json', TRUE);

        $this->getResponse()->setBody(json_encode($stat));
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/pgp');
    }

    /**
     * Render grid
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
