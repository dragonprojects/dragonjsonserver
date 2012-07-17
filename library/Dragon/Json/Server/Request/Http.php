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
 * Requestklasse mit allen Angaben eines JsonRPC Requests
 */
class Dragon_Json_Server_Request_Http extends Zend_Json_Server_Request_Http
{
	/**
	 * Übernimmt die übergebenen Parameter oder holt diese aus den Post Daten
	 * @param array $options
	 */
	public function __construct(array $options = null)
	{
		if (isset($options)) {
			$this->setOptions($options);
		} else {
			parent::__construct();
		}
	}

	/**
	 * Prüft den erforderlichen Parameter und gibt dessen Wert zurück
	 * @param string $name
	 * @return mixed
	 * @throws InvalidArgumentException
	 */
    public function getRequiredParam($name)
    {
        $param = $this->getParam($name);
        if (!isset($param)) {
            throw new InvalidArgumentException('required param "' . $name . '"');
        }
        return $param;
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
     * @return mixed
     */
    public function getOptionalParam($name, $default = null)
    {
        $param = $this->getParam($name);
        if (!isset($param)) {
            return $default;
        }
        return $param;
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
