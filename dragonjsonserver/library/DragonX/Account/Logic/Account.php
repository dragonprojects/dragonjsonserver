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
 * Logikklasse zur Erstellung von Accounts
 */
class DragonX_Account_Logic_Account
{
    /**
     * Erstellt einen neuen Account
     * @return Application_Account_Record_Account
     */
    public function createAccount()
    {
        $recordAccount = new Application_Account_Record_Account();
        Zend_Registry::get('DragonX_Storage_Engine')->save($recordAccount);
        Zend_Registry::get('Dragon_Plugin_Registry')->invoke(
            'DragonX_Account_Plugin_LoadAccount_Interface',
            array($recordAccount)
        );
        Zend_Registry::get('Dragon_Plugin_Registry')->invoke(
            'DragonX_Account_Plugin_CreateAccount_Interface',
            array($recordAccount)
        );
        Zend_Registry::set('recordAccount', $recordAccount);
        return $recordAccount;
    }

    /**
     * Setzt den Zeitpunkt des letzten Requests auf den aktuellen Zeitpunkt
     * @param Application_Account_Record_Account $recordAccount
     */
    public function requestAccount(Application_Account_Record_Account $recordAccount)
    {
        Zend_Registry::get('DragonX_Storage_Engine')->save($recordAccount);
    }
}
