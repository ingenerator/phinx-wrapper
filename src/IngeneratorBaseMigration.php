<?php
/**
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @licence   proprietary
 */

namespace Ingenerator\PhinxWrapper;

use PDO;
use PDOStatement;
use Phinx\Db\Adapter\PdoAdapter;
use Phinx\Migration\AbstractMigration;
use Phinx\Migration\IrreversibleMigrationException;

abstract class IngeneratorBaseMigration extends AbstractMigration
{

    final public function down()
    {
        throw new IrreversibleMigrationException;
    }

    /**
     * @param string $sql
     *
     * @return PDOStatement
     */
    public function query($sql)
    {
        return parent::query($sql);
    }

    /**
     * @param string $sql
     *
     * @return array
     */
    public function fetchRow($sql)
    {
        return $this->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     *
     * @return array
     */
    public function fetchAll($sql)
    {
        $rows   = [];
        $result = $this->query($sql);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @return \Phinx\Db\Adapter\PdoAdapter
     */
    public function getAdapter()
    {
        return parent::getAdapter();
    }

    final public function createDatabase($name, $options)
    {
        throw new \BadMethodCallException(__METHOD__.' not allowed - just execute SQL!');
    }

    final public function dropDatabase($name)
    {
        throw new \BadMethodCallException(__METHOD__.' not allowed - just execute SQL!');
    }

    final public function dropTable($tableName)
    {
        throw new \BadMethodCallException(__METHOD__.' not allowed - just execute SQL!');
    }

    final public function table($tableName, $options = [])
    {
        throw new \BadMethodCallException(__METHOD__.' not allowed - just execute SQL!');
    }

    /**
     * @param string $sql
     * @param array  $params
     */
    protected function prepareAndExecute($sql, $params)
    {
        $this->getAdapter()->getConnection()->prepare($sql)->execute($params);
    }

}
