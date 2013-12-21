<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Helper_Data extends Mage_Core_Helper_Abstract
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

    /**
     * if isForcePlainText and strip tags true, then all HTML will be removed
     *
     * @return bool
     */
    public function isHtmlToText()
    {
        return (int)Mage::getStoreConfig('schumacherfm/pgp/email_html_to_text') === 1;
    }

    /**
     * @return bool
     */
    public function isMoveSubjectToBody()
    {
        return (int)Mage::getStoreConfig('schumacherfm/pgp/email_move_subject_to_body') === 1;
    }

    /**
     * @todo more configurable options
     *
     * @return array|bool
     */
    public function getRandomSender()
    {

        if ((int)Mage::getStoreConfig('schumacherfm/pgp/email_random_sender') === 0) {
            return FALSE;
        }
        $mail   = 'john.doe.' . time() . '@gmail.com';
        $return = array(
            'sender_email'      => $mail,
            'sender_name'       => 'John Doe',
            'return_path_email' => $mail,
        );
        return $return;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return Mage::getStoreConfig('schumacherfm/pgp/engine');

    }

    /**
     * @param string $asc
     *
     * @return bool
     */
    public function isPublicKey($asc)
    {
        return strpos($asc, '-----BEGIN PGP PUBLIC KEY BLOCK-----') !== FALSE;
    }

    /**
     * @param $fileName
     *
     * @return bool
     */
    public function isAllowedUploadedFile($fileName)
    {

        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $allowed   = array(
            'asc' => 1,
            'txt' => 1,
            'pub' => 1,
        );
        $extension = strtolower($extension);
        return isset($allowed[$extension]);

    }

}