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
 * Plugin zur Speicherung der Request- und Responsedaten
 */
class DragonX_Log_Plugin_Request
    implements Dragon_Json_Plugin_PreDispatch_Interface,
               Dragon_Json_Plugin_PostDispatch_Interface
{
    /**
     * Loggt vor jedem Request die Requestparameter und den Requesttimestamp
     * @param Dragon_Json_Server_Request_Http $request
     */
    public function preDispatch(Dragon_Json_Server_Request_Http $request)
    {
        $logicRequest = new DragonX_Log_Logic_Request();
        $logicRequest->request($request->getMethod(), $request->getId(), $request->getVersion(), $request->getParams());
    }

    /**
     * Loggt nach jedem Request die Response und den Responsetimestamp
     * @param Dragon_Json_Server_Request_Http $request
     * @param Dragon_Json_Server_Response_Http $response
     */
    public function postDispatch(Dragon_Json_Server_Request_Http $request, Dragon_Json_Server_Response_Http $response)
    {
        $logicRequest = new DragonX_Log_Logic_Request();
        $logicRequest->response($response->toArray());
    }
}
