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
     * disable sending via attachment, after decryption user will see plain HTML, not rendered one.
     *
     * @return bool
     */
    public function isForcePlainText()
    {
        return (int)Mage::getStoreConfig('schumacherfm/pgp/email_force_plain_text') === 1;
    }
}