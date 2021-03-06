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
 * Logikklasse zur Verwaltung von Nested Sets
 */
class DragonX_NestedSet_Logic_NestedSet
{
    /**
     * Lädt den Wurzelknoten für den übergebenen Knoten des Nested Set
     * @param DragonX_NestedSet_Record_NestedSet $node
     * @return DragonX_NestedSet_Record_NestedSet
     */
    public function getRootNode(DragonX_NestedSet_Record_NestedSet $node)
    {
        $storage = Zend_Registry::get('DragonX_Storage_Engine');
        list ($recordNode) = $storage->loadByConditions($node, array('lft' => 1));
        return $recordNode;
    }

    /**
     * Fügt einen Knoten unter den Parent Knoten dem Nested Set hinzu
     * @param DragonX_NestedSet_Record_NestedSet $node
     * @param DragonX_NestedSet_Record_NestedSet $parent
     */
    public function addNode(DragonX_NestedSet_Record_NestedSet $node, DragonX_NestedSet_Record_NestedSet $parent = null)
    {
        $storage = Zend_Registry::get('DragonX_Storage_Engine');
        $storage->beginTransaction();
    	if (isset($node->id)) {
    		$this->removeNode($node);
    	}
        if (isset($parent)) {
        	if (!$node instanceof $parent) {
        		throw new Dragon_Application_Exception_System('incorrect nodeclass', array('nodeclass' => get_class($node), 'parentclass' => get_class($parent)));
        	}
        	try {
        	    $storage->load($parent);
        	} catch (Exception $exception) {
                $storage->rollback();
        	    throw $exception;
        	}
            $node->lft = $parent->rgt;
            $node->rgt = $node->lft + 1;
            $storage->executeSqlStatement(
                "UPDATE `" . $storage->getTablename($node) . "` SET `rgt` = `rgt` + 2 WHERE `rgt` >= :rgt",
                array('rgt' => $parent->rgt)
            );
            $storage->executeSqlStatement(
                "UPDATE `" . $storage->getTablename($node) . "` SET `lft` = `lft` + 2 WHERE `lft` > :rgt",
                array('rgt' => $parent->rgt)
            );
        } else {
            $node->lft = 1;
            $node->rgt = 2;
            $storage->executeSqlStatement("TRUNCATE `" . $storage->getTablename($node) . "`");
        }
        $storage->save($node);
        $storage->commit();
    }

    /**
     * Entfernt einen Knoten mit seinen Nachfahren aus dem Nested Set
     * @param DragonX_NestedSet_Record_NestedSet $node
     */
    public function removeNode(DragonX_NestedSet_Record_NestedSet $node)
    {
    	$storage = Zend_Registry::get('DragonX_Storage_Engine');
    	$storage->beginTransaction();
        try {
            $storage->load($node);
        } catch (Exception $exception) {
            $storage->rollback();
            return;
        }
        $storage->executeSqlStatement(
            "DELETE FROM `" . $storage->getTablename($node) . "` WHERE `lft` BETWEEN :lft AND :rgt",
            array('lft' => $node->lft, 'rgt' => $node->rgt)
        );
        $storage->executeSqlStatement(
            "UPDATE `" . $storage->getTablename($node) . "` SET `lft` = `lft` - ROUND((:rgt - :lft + 1)) WHERE `lft` > :rgt",
            array('lft' => $node->lft, 'rgt' => $node->rgt)
        );
        $storage->executeSqlStatement(
            "UPDATE `" . $storage->getTablename($node) . "` SET `rgt` = `rgt` - ROUND((:rgt - :lft + 1)) WHERE `rgt` > :rgt",
            array('lft' => $node->lft, 'rgt' => $node->rgt)
        );
        unset($node->id);
        unset($node->lft);
        unset($node->rgt);
        $storage->commit();
    }
}
