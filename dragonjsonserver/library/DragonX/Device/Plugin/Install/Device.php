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
 * Plugin zur Installation des Paketes
 */
class DragonX_Device_Plugin_Install_Device implements DragonX_Storage_Plugin_Install_Interface
{
    /**
     * Installiert das Plugin in der übergebenen Datenbank
     * @param DragonX_Storage_Engine_ZendDbAdataper $storage
     * @param string $version
     */
    public function install(DragonX_Storage_Engine_ZendDbAdataper $storage, $version = '0.0.0')
    {
        if (version_compare($version, '1.8.0', '<')) {
            $storage->executeSqlStatement(
                  "CREATE TABLE `dragonx_device_record_device` ("
                    . "`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, "
                    . "`created` INT(10) UNSIGNED NOT NULL, "
                    . "`modified` INT(10) UNSIGNED NOT NULL, "
                    . "`account_id` INT(10) UNSIGNED NOT NULL, "
                    . "`platform` VARCHAR(255) NOT NULL, "
                    . "`name` VARCHAR(255) NOT NULL, "
                    . "PRIMARY KEY (`id`)"
                . ") ENGINE=InnoDB DEFAULT CHARSET=utf8"
            );
        }
        if (version_compare($version, '1.13.0', '<')) {
        	$storage->executeSqlStatement("DROP TABLE `dragonx_device_record_device`");
            $storage->executeSqlStatement(
                  "CREATE TABLE `dragonx_device_record_device` ("
                    . "`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, "
                    . "`created` INT(10) UNSIGNED NOT NULL, "
                    . "`modified` INT(10) UNSIGNED NOT NULL, "
                    . "`account_id` INT(10) UNSIGNED NOT NULL, "
                    . "`platform` VARCHAR(255) NOT NULL, "
                    . "`devicename` VARCHAR(255) NOT NULL, "
                    . "`locale_register` CHAR(5) NOT NULL, "
                    . "`locale_actual` CHAR(5) NOT NULL, "
                    . "PRIMARY KEY (`id`), "
                    . "KEY (`account_id`)"
                . ") ENGINE=InnoDB DEFAULT CHARSET=utf8"
            );
        }
    }
}
