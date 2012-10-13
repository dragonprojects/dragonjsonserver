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
 * @return array
 */
return array(
    'Dragon' => array(
        'Application' => array(
            'Service' => array('Application')
        ),
        'Json',
        'Package',
        'Plugin',
        'Repository',
    ),
    'DragonX' => array(
        'Account' => array(
            'Plugin' => array('Account', 'Deletion', 'Session', 'Install'),
            'Service' => array('Account', 'Deletion', 'Session'),
        ),
        'Acl' => array(
            'Plugin' => array('Acl', 'Install'),
        ),
        'Application',
        'Clientmessage' => array(
            'Plugin' => array('Clientmessage', 'Account', 'All', 'Install'),
        ),
        'Cronjob' => array(
            'Plugin' => array('Install'),
            'Service' => array('Cronjob'),
        ),
        'Device' => array(
            'Plugin' => array('Install'),
            'Service' => array('Device'),
        ),
        'Emailaddress' => array(
            'Plugin' => array('Install'),
            'Service' => array('Credential', 'Emailaddress', 'Validation'),
        ),
        'Homepage',
        'Log' => array(
            'Plugin' => array('Log', 'Request', 'Install'),
        ),
        'NestedSet',
        'Storage' => array(
            'Plugin' => array('Database', 'Storage'),
        ),
    ),
    'Application' => array(
        'Account' => array(
            'Plugin' => array('Install'),
        ),
    ),
);
