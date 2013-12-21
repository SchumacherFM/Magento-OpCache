<?php
/**
 * @category    SchumacherFM_OpCachePanel
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_OpCachePanel_Block_Adminhtml_OpCachePanelkey_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set defaults
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('pgpGrid');
        $this->setDefaultSort('updated_at');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(TRUE);
        $this->setUseAjax(TRUE);
        $this->setVarNameFilter('pgpkey_filter');
    }

    /**
     * Instantiate and prepare collection
     *
     * @return SchumacherFM_OpCachePanel_Model_Resource_Pubkeys_Collection
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('pgp/pubkeys')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Define grid columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn('key_id',
            array(
                'header' => Mage::helper('pgp')->__('Key ID'),
                'width'  => 5,
                'type'   => 'text',
                'index'  => 'key_id',
            ));

        $this->addColumn('email', array(
            'header' => Mage::helper('pgp')->__('Email'),
            'type'   => 'text',
            'index'  => 'email',
            'escape' => TRUE
        ));

        $this->addColumn('updated_at', array(
            'header' => Mage::helper('pgp')->__('Last update'),
            'type'   => 'datetime',
            'index'  => 'updated_at',
            'escape' => TRUE
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('pgp')->__('Created'),
            'type'   => 'datetime',
            'index'  => 'created_at',
            'escape' => TRUE
        ));

        return parent::_prepareColumns();
    }

    /**
     * Prepare mass action options for this grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('key_id');
        $this->getMassactionBlock()->setFormFieldName('pgpkey');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'   => Mage::helper('pgp')->__('Delete'),
            'url'     => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('pgp')->__('Are you sure you want to delete these keys?')
        ));

        return $this;
    }

    /**
     * Grid row URL getter
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getKeyId()));
    }

    /**
     * Define row click callback
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => TRUE));
    }

    /**
     * Add store filter
     *
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     *
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getIndex() == 'stores') {
            $this->getCollection()->addStoreFilter($column->getFilter()->getCondition(), FALSE);
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
