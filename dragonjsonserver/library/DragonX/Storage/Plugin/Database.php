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
 * Plugin zur Initialisierung des Datenbankadapters bei jedem Request
 */
class DragonX_Storage_Plugin_Database implements Dragon_Application_Plugin_Bootstrap_Interface
{
    /**
     * Initialisiert bei jedem Request den Datenbankadapter
     */
    public function bootstrap()
    {
    	$registry = Dragon_Application_Registry::getInstance();
        $configDatabase = new Dragon_Application_Config('dragonx/storage/database');
        if (isset($configDatabase->adapter)) {
            $registry->setCallback('Zend_Db_Adapter', function() use($configDatabase) { return Zend_Db::factory($configDatabase->adapter, $configDatabase->config); });
        } else {
        	$configDatabases = $configDatabase;
        	foreach ($configDatabases as $storagekey => $configDatabase) {
                $registry->setCallback($storagekey, function() use($configDatabase) { return Zend_Db::factory($configDatabase->adapter, $configDatabase->config); });
        	}
        }
    }
}
