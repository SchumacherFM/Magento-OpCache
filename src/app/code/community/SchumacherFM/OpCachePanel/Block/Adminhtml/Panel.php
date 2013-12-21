<?php
/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_Panel extends SchumacherFM_OpCachePanel_Block_Adminhtml_AbstractOpCache
{

    public function _construct()
    {
        parent::_construct();
        $this->setTitle('OpCache Panel');
    }

    protected function _prepareLayout()
    {
        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('adminhtml')->__('Reset'),
                    'onclick' => 'configForm.submit()',
                    'class'   => 'save',
                ))
        );
        return parent::_prepareLayout();
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current' => TRUE));
    }
}
