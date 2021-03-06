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
 * Plugin zur Initialisierung der AccountID als Log Event Item
 */
class DragonX_Log_Plugin_Account implements DragonX_Account_Plugin_LoadAccount_Interface
{
    /**
     * Wird nach dem Laden eines Accounts aufgerufen
     * @param Application_Account_Record_Account $recordAccount
     */
    public function loadAccount(Application_Account_Record_Account $recordAccount)
    {
        if (Zend_Registry::isRegistered('Zend_Log')) {
            $logger = Zend_Registry::get('Zend_Log');
            $logger->setEventItem('account_id', $recordAccount->id);
        }
    }
}
