<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled with this
 * package in the file LICENSE.txt. It is also available through the
 * world-wide-web at this URL: http://dragonjsonserver.de/license. If you did
 * not receive a copy of the license and are unable to obtain it through the
 * world-wide-web, please send an email to license@dragonjsonserver.de. So we
 * can send you a copy immediately.
 *
 * @copyright Copyright (c) 2012 DragonProjects (http://dragonprojects.de)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author Christoph Herrmann <developer@dragonjsonserver.de>
 */

/**
 * Logikklasse zur Verarbeitung von Validierungsabfragen
 */
class DragonX_Emailaddress_Logic_Validation
{
    /**
     * Ändert die E-Mail Adresse trägt eine neue Validierungabfrage ein
     * @param DragonX_Emailaddress_Record_Emailaddress $recordEmailaddress
     * @param string $newemailaddress
     * @param Zend_Config $configMail
     * @throws InvalidArgumentException
     */
    public function changeEmailaddress(DragonX_Emailaddress_Record_Emailaddress $recordEmailaddress, $newemailaddress, Zend_Config $configMail)
    {
        $recordEmailaddress->validateEmailaddress($newemailaddress);
        Zend_Registry::get('DragonX_Storage_Engine')->save($recordEmailaddress);

        $logicValidation = new DragonX_Emailaddress_Logic_Validation();
        $logicValidation->request($recordEmailaddress, $configMail);

        Zend_Registry::get('Dragon_Plugin_Registry')->invoke(
            'DragonX_Emailaddress_Plugin_ChangeEmailaddress_Interface',
            array($recordEmailaddress)
        );
    }

    /**
     * Lädt den Account und speichert einen neuen Hash zur Validierung
     * @param DragonX_Emailaddress_Record_Emailaddress $recordEmailaddress
     * @param Zend_Config $configMail
     */
    public function request(DragonX_Emailaddress_Record_Emailaddress $recordEmailaddress, Zend_Config $configMail)
    {
        $recordValidation = new DragonX_Emailaddress_Record_Validation(array(
            'emailaddressid' => $recordEmailaddress->id,
            'validationhash' => md5($recordEmailaddress->id . '.' . time()),
        ));
        Zend_Registry::get('DragonX_Storage_Engine')->save($recordValidation);

        $bodytext = str_replace(
            array('%validationhash%', '%validationlink%'),
            array(
                $recordValidation->validationhash,
                BASEURL . 'validation/validate?validationhash=' . $recordValidation->validationhash
            ),
            $configMail->bodytext
        );
        $mail = new Zend_Mail();
        $mail
            ->setBodyText($bodytext)
            ->addTo($recordEmailaddress->emailaddress)
            ->setSubject($configMail->subject)
            ->send();
    }

    /**
     * Entfernt die Validierungsabfrage und schaltet somit den Account frei
     * @param string $validationhash
     */
    public function validate($validationhash)
    {
        $storage = Zend_Registry::get('DragonX_Storage_Engine');

        $listValidations = $storage->loadByConditions(
            new DragonX_Emailaddress_Record_Validation(),
            array('validationhash' => $validationhash)
        );
        if (count($listValidations) == 0) {
            throw new InvalidArgumentException('incorrect validationhash');
        }
        list($recordValidation) = $listValidations;

        if (!$recordEmailaddress = $storage->load(new DragonX_Emailaddress_Record_Emailaddress($recordValidation->emailaddressid))) {
            throw new Exception('incorrect emailaddressid');
        }
        $storage->delete($recordValidation);

        Zend_Registry::get('Dragon_Plugin_Registry')->invoke(
            'DragonX_Emailaddress_Plugin_ValidateEmailaddress_Interface',
            array($recordEmailaddress)
        );

        if (!$recordAccount = $storage->load(DragonX_Account_Record_Account::newInstance($recordEmailaddress->accountid))) {
            throw new Exception('incorrect accountid');
        }
        return $recordAccount;
    }
}
