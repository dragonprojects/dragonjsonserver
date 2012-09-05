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

require 'bootstrap.php';
$jsonserver = new Dragon_Json_Server();
$jsonserver->handle(
    new Dragon_Json_Server_Request_Http(array(
        'id' => 'cron.php',
        'method' => 'DragonX.Cronjob.Service.Cronjob.executeCronjobs',
        'params' => array('securitytoken' => isset($_GET['securitytoken']) ? $_GET['securitytoken'] : ''),
    ))
);