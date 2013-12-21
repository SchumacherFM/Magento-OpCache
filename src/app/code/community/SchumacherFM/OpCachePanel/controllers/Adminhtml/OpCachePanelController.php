<?php
/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Controller
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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

    }

    public function recheckAction()
    {

    }

    /**
     * @todo use http://snapsvg.io/ for chart generation
     */
    public function graphDataJsonAction(){

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
