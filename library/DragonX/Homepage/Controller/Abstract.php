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
 * Controller zum Setzen aller Daten des Layouts
 */
abstract class DragonX_Homepage_Controller_Abstract extends Zend_Controller_Action
{
    /**
     * Setzt alle Daten des Layouts aus den Einstellungsdateien
     */
    public function preDispatch()
    {
        parent::preDispatch();

        $this->view->configApplication = new Dragon_Application_Config('dragon/application/application');
        $this->view->modulename = $this->getRequest()->getModuleName();
        $this->view->controllername = $this->getRequest()->getControllerName();
        switch ($this->view->modulename) {
        	case 'homepage':
        		$this->view->configNavigation = new Dragon_Application_Config('dragonx/homepage/navigation');
        		break;
        	case 'administration':
                $this->view->configNavigation = new Dragon_Application_Config('dragonx/administration/navigation');
		        $sessionNamespace = new Zend_Session_Namespace();
                if (!isset($sessionNamespace->recordAccount)) {
                	$frontController = $this->getFrontController();
                    $defaultcontrollername = $frontController->getDefaultControllerName();
                	$actionname = $this->getRequest()->getActionName();
                	$defaultactionname = $frontController->getDefaultAction();
                    $params = array();
                	if ($this->view->controllername != $defaultcontrollername
                	    ||
                	    $actionname != $defaultactionname) {
                	    if ($this->view->controllername != $defaultcontrollername) {
                	    	if ($actionname == $defaultactionname) {
	                	    	$params = array('redirect' => 'administration/' . $this->view->controllername);
                	    	} else {
	                	    	$params = array('redirect' => 'administration/' . $this->view->controllername . '/' . $actionname);
                	    	}
                	    } elseif ($actionname != $defaultactionname) {
                	    	$params = array('redirect' => 'administration/' . $this->view->controllername . '/' . $actionname);
                	    }
                	}
                	$redirect = '';
                	if (count($params) > 0) {
                		$redirect = '?' . http_build_query($params);
                	}
                	$this->_redirect('account/showlogin' . $redirect);
                }
                $logicAccount = new DragonX_Account_Logic_Account();
                $this->view->recordDeletion = $logicAccount->getDeletion($sessionNamespace->recordAccount);
                if (isset($this->view->recordDeletion)) {
                	$this->view->configDeletion = new Dragon_Application_Config('dragonx/account/deletion');
                }
        		break;
        }
    }

    /**
     * Setzt alle Daten des Layouts der Session
     */
    public function postDispatch()
    {
        parent::postDispatch();

        $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        $sessionNamespace = new Zend_Session_Namespace();
        $this->view->recordAccount = $sessionNamespace->recordAccount;
    }

    /**
     * Gibt alle Parameter des Requests zurück
     * @return array
     */
    public function getParams($name)
    {
        return $this->_getAllParams();
    }

    /**
     * Prüft den erforderlichen Parameter und gibt dessen Wert zurück
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getRequiredParam($name)
    {
        if (!$this->_hasParam($name)) {
            throw new InvalidArgumentException('required param "' . $name . '"');
        }
        return $this->_getParam($name);
    }

    /**
     * Prüft die erforderlichen Parameter und gibt deren Werte zurück
     * @param array $names
     * @return array
     * @throws InvalidArgumentException
     */
    public function getRequiredParams($names)
    {
        $params = array();
        foreach ($names as $name) {
            $params[$name] = $this->getRequiredParam($name);
        }
        return $params;
    }

    /**
     * Gibt den optionalen Parameter oder den Standardwert zurück
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOptionalParam($name, $default = null)
    {
        return $this->_getParam($name, $default);
    }

    /**
     * Gibt die optionalen Parameter oder die Standardwerte zurück
     * @param array $names
     * @return array
     */
    public function getOptionalParams(array $names)
    {
        $params = array();
        foreach ($names as $name => $default) {
            $params[$name] = $this->getOptionalParam($name, $default);
        }
        return $params;
    }
}
