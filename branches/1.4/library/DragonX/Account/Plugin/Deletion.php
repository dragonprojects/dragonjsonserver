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
 * Plugins zur Löschung der Accounts die zum Löschen markiert wurden
 */
class DragonX_Account_Plugin_Deletion implements DragonX_Cronjob_Plugin_Cronjob_Interface
{
    /**
     * Gibt den Intervall zwischen den Cronjobs zurück
     * @return integer
     */
    public function getIntervall()
    {
        return 1 * 24 * 60;
    }

    /**
     * Gibt das Offset zum Intervall des Cronjobs zurück
     * @return integer
     */
    public function getOffset()
    {
        return 0;
    }

    /**
     * Führt den Cronjob aus
     */
    public function execute()
    {
    	$storage = Zend_Registry::get('DragonX_Storage_Engine');

    	$timestamp = time();

    	$listAccounts = $storage->loadBySqlStatement(
    	    new DragonX_Account_Record_Account(),
              "SELECT * FROM `dragonx_account_record_account` WHERE `id` IN ("
                . "SELECT `accountid` FROM `dragonx_account_record_deletion` WHERE `timestamp` <= :timestamp"
            . ")",
            array('timestamp' => $timestamp)
        );
        Zend_Registry::get('Dragon_Plugin_Registry')->invoke(
            'DragonX_Account_Plugin_DeleteAccounts_Interface',
            array($listAccounts)
        );

        Zend_Registry::get('DragonX_Storage_Engine')->executeSqlStatement(
              "DELETE FROM `dragonx_account_record_account` WHERE `id` IN ("
                . "SELECT `accountid` FROM `dragonx_account_record_deletion` WHERE `timestamp` <= :timestamp"
            . ")",
            array('timestamp' => $timestamp)
        );
    }
}
