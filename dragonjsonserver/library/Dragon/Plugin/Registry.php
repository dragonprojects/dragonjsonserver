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
 * Klasse zur Verwaltung der Plugins aller Pakete
 */
class Dragon_Plugin_Registry
{
    /**
     * @var string
     */
    private $_filepath;

    /**
     * @var array
     */
    private $_plugins = array();

    /**
     * @var array
     */
    private $_unsortedplugins = array();

    /**
     * @var array
     */
    private $_sortedplugins = array();

    /**
     * Fügt mehrere Plugins hinzu und registriert diese bei allen Schnittstellen
     * @param array $plugins
     */
    public function __construct(array $plugins)
    {
    	$configCache = new Dragon_Application_Config('dragon/plugin/cache');
    	$this->_filepath = $configCache->filepath;
    	if (isset($this->_filepath) && is_file($this->_filepath)) {
    		list($this->_plugins, $this->_unsortedplugins, $this->_sortedplugins) = unserialize(file_get_contents($this->_filepath));
    	} else {
	        foreach ($plugins as $plugin) {
	        	if (is_object($plugin)) {
	        		$pluginname = get_class($plugin);
	        	} else {
	        		$pluginname = $plugin;
	        	}
                $this->_plugins[$pluginname] = $pluginname;
	            $reflectionClass = new ReflectionClass($plugin);
	            foreach ($reflectionClass->getInterfaceNames() as $interfacename) {
	                if (!isset($this->_unsortedplugins[$interfacename])) {
	                    $this->_unsortedplugins[$interfacename] = array();
	                }
	                $this->_unsortedplugins[$interfacename][] = $plugin;
	            }
	        }
	        if (isset($this->_filepath)) {
	        	file_put_contents($this->_filepath, serialize(array($this->_plugins, $this->_unsortedplugins, $this->_sortedplugins)));
	        }
    	}
    }

    /**
     * Sortiert die Plugins in Topologischer Reihenfolge ihrer Abhängigkeiten
     * @param array $plugins
     * @return array
     */
    private function sortPlugins(array $plugins)
    {
    	$list = array();
    	$nodes = array();
    	foreach ($plugins as $plugin) {
    		if (!is_object($plugin)) {
                $plugin = $this->getPlugin($plugin);
    		}
    		$pluginname = get_class($plugin);
    		$list[$pluginname] = $plugin;
    		if ($plugin instanceof Dragon_Plugin_Plugin_GetDependencies_Interface) {
    			foreach ($plugin->getDependencies() as $dependency) {
    				$nodes[] = array($pluginname, $dependency);
    			}
    		}
    	}
    	unset($plugin);
	    $sortlist = array();
	    while (count($list) > 0) {
	        $circle = true;
	        foreach ($list as $listkey => $element) {
	            $dependency = false;
	            foreach ($nodes as $node) {
	                list ($from, $to) = $node;
	                if ($listkey == $from) {
	                    $dependency = true;
	                }
	            }
	            if (!$dependency) {
	                $circle = false;
	                $sortlist[] = $element;
	                unset($list[$listkey]);
	                foreach ($nodes as $nodekey => $node) {
	                    list ($from, $to) = $node;
	                    if ($listkey == $to) {
	                        unset($nodes[$nodekey]);
	                    }
	                }
	            }
	        }
	        if ($circle) {
	            throw new Dragon_Application_Exception_System('found circle', array('list' => $list, 'nodes' => $nodes));
	        }
	    }
	    return $sortlist;
    }

    /**
     * Gibt das Objekt des übergebenen Plugins zurück
     * @param string $pluginname
     * @return object
     */
    public function getPlugin($pluginname)
    {
        if (!isset($this->_plugins[$pluginname])) {
            throw new Dragon_Application_Exception_System('incorrect pluginname', array('pluginname' => $pluginname));
        }
        if (!is_object($this->_plugins[$pluginname])) {
            $this->_plugins[$pluginname] = new $pluginname();
        }
        return $this->_plugins[$pluginname];
    }

    /**
     * Gibt alle Plugins der übergebenen Schnittstelle zurück
     * @param string $interfacename
     * @return array
     */
    public function getPlugins($interfacename)
    {
        if (!isset($this->_unsortedplugins[$interfacename])) {
            return array();
        }
        if (!isset($this->_sortedplugins[$interfacename])) {
        	$this->_sortedplugins[$interfacename] = $this->sortPlugins($this->_unsortedplugins[$interfacename]);
	        if (isset($this->_filepath)) {
	        	file_put_contents($this->_filepath, serialize(array($this->_plugins, $this->_unsortedplugins, $this->_sortedplugins)));
	        }
        }
        return $this->_sortedplugins[$interfacename];
    }

    /**
     * Führt die Methode mit den Paremetern aller Plugins der Schnittstelle aus
     * @param string $interfacename
     * @param array $params
     * @param string $methodname
     * @return Dragon_Plugin_Registry
     */
    public function invoke($interfacename, $params = array(), $methodname = null)
    {
        if (!isset($methodname)) {
            $reflectionClass = new ReflectionClass($interfacename);
            $reflectionMethods = $reflectionClass->getMethods();
            if (count($reflectionMethods) == 0) {
                return;
            }
            $methodname = $reflectionMethods[0]->name;
        }
        $plugins = $this->getPlugins($interfacename);
        foreach ($plugins as $plugin) {
            call_user_func_array(array($plugin, $methodname), $params);
        }
        return $this;
    }
}
