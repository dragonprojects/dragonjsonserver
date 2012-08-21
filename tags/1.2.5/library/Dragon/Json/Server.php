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
 * Klasse zur Verarbeitung von JsonRPC Requests
 */
class Dragon_Json_Server extends Zend_Json_Server
{
    /**
     * Verarbeitet den JsonRPC Request
     */
    protected function _handle()
    {
        try {
            $pluginregistry = Zend_Registry::get('Dragon_Plugin_Registry');
            $request = $this->getRequest();
            $pluginregistry->invoke(
                'Dragon_Json_Plugin_PreDispatch_Interface',
                array($request)
            );
            parent::_handle();
            $pluginregistry->invoke(
                'Dragon_Json_Plugin_PostDispatch_Interface',
                array($request, $this->getResponse())
            );
        } catch (Exception $e) {
            $this->fault($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Verarbeitet einen Aufruf des Json Servers
     * @param null $request
     * @return mixed|null|Zend_Json_Server_Response
     * @throws InvalidArgumentException
     */
    public function handle($request = null)
    {
        $requestmethod = null;
        if (isset($request)) {
            if (!$request instanceof Dragon_Json_Server_Request_Http) {
                throw new InvalidArgumentException('request is not instanceof Dragon_Json_Server_Request_Http');
            }
            $requestmethod = 'POST';
        } else {
            $request = new Dragon_Json_Server_Request_Http();
        }
        if (!isset($requestmethod)) {
            $requestmethod = $_SERVER['REQUEST_METHOD'];
        }
        $packageregistry = Zend_Registry::get('Dragon_Package_Registry');
        foreach ($packageregistry->getClassnames('Service') as $servicename) {
            $this->setClass($servicename, str_replace('_', '.', $servicename));
        }
        switch ($requestmethod) {
            case 'POST':
                $this->setResponse(new Dragon_Json_Server_Response_Http());
                return parent::handle($request);
                break;
            case 'GET':
                header('Content-Type: application/json');
                $servicemap = $this->getServiceMap();
                Zend_Registry::get('Dragon_Plugin_Registry')->invoke(
                    'Dragon_Json_Plugin_Servicemap_Interface',
                    array($servicemap)
                );
                echo $servicemap;
                break;
        }
    }

    /**
     * Verarbeitet einen Multirequest des Json Servers
     * @param array $requests
     * @return null|array
     * @throws InvalidArgumentException
     */
    public function handleMultirequest(array $requests = null)
    {
    	if (!isset($requests)) {
			$json = file_get_contents('php://input');
			$requests = Zend_Json::decode($json);
    	}
    	if (count($requests) == 0) {
    		throw new InvalidArgumentException('missing requests');
    	}
    	$autoemitresponse = $this->autoEmitResponse();
		$this->setAutoEmitResponse(false);
		$params = array();
		$responses = array();
		foreach ($requests as $request) {
		    $request['params'] += $params;
		    $response = $this->handle(new Dragon_Json_Server_Request_Http($request))->toArray();
		    if (isset($response['result']) && is_array($response['result'])) {
		        $params += $response['result'];
		    }
		    $responses[] = $response;
		}
		if (!$autoemitresponse) {
			return $responses;
		}
		$response = end($responses);
		if ($response) {
		    $response->sendHeaders();
		    reset($responses);
		}
		echo Zend_Json::encode($responses);
    }
}
