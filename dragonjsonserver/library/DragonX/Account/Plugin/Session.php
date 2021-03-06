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
 * Plugin zur Löschung der Sessions die abgelaufen sind
 */
class DragonX_Account_Plugin_Session implements DragonX_Cronjob_Plugin_Cronjob_Interface
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
        $configSession = new Dragon_Application_Config('dragonx/account/session');
    	$listSessions = Zend_Registry::get('DragonX_Storage_Engine')->loadBySqlStatement(
    	    new DragonX_Account_Record_Session(),
            "SELECT * FROM `dragonx_account_record_session` WHERE `created` IS NOT NULL AND `created` <= :timestamp",
            array('timestamp' => time() - $configSession->lifetime)
        );
        $logicAccount = new DragonX_Account_Logic_Account();
        foreach ($listSessions as $recordSession) {
        	$logicAccount->logoutAccount($recordSession->sessionhash);
        }
    }
}
