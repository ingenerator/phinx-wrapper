<?php
/**
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @licence   proprietary
 */

namespace Ingenerator\PhinxWrapper;

/**
 * Parses connection information from a .my.cnf file
 *
 * @package Ingenerator\PhinxWrapper
 */
class MyDotCnfFileConnectionProvider implements DatabaseConnectionProvider
{
    /**
     * @var string
     */
    protected $cnf_file;

    /**
     * MyDotCnfFileConnectionProvider constructor.
     *
     * @param $config_path
     */
    public function __construct($config_path)
    {
        $this->cnf_file = $config_path;
    }

    /**
     * @return array
     */
    public function getConnectionInfo()
    {
        if ( ! is_file($this->cnf_file)) {
            throw new \RuntimeException('Cannot find mysql config file in '.$this->cnf_file);
        }

        $mysql_ini = $this->parseMysqlInFile($this->cnf_file);

        if ( ! isset($mysql_ini['client']['password'])) {
            throw new \InvalidArgumentException('Cannot find mysql password in '.$this->cnf_file);
        }

        if ( ! isset($mysql_ini['client']['user'])) {
            throw new \InvalidArgumentException('Cannot find mysql user in '.$this->cnf_file);
        }

        return [
            'adapter' => 'mysql',
            'user'    => $mysql_ini['client']['user'],
            'pass'    => $mysql_ini['client']['password'],
            'host'    => '127.0.0.1',
            'port'    => 3306,
            'charset' => 'utf8',
        ];
    }

    /**
     * @param $config_file
     *
     * @return array|bool
     */
    protected function parseMysqlInFile($config_file)
    {
        $mysql_config = file_get_contents($config_file);
        $mysql_ini    = parse_ini_string(preg_replace('/^\s*#/m', ';', $mysql_config), TRUE);

        if ( ! $mysql_ini) {
            throw new \InvalidArgumentException('Cannot parse '.$config_file.' as ini file');
        }

        return $mysql_ini;
    }

}
