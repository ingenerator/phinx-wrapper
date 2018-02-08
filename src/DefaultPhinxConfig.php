<?php
/**
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @licence   proprietary
 */

namespace Ingenerator\PhinxWrapper;


/**
 * Builds configuration for Phinx
 *
 * @package Ingenerator\PhinxWrapper
 */
class DefaultPhinxConfig
{

    /**
     * @var DatabaseConnectionProvider
     */
    protected $connection;

    /**
     * Build configuration for a local database using a local .my.cnf file
     *
     * @param string $path - defaults to $/.my.cnf
     *
     * @return static
     */
    public static function fromMyDotCnf($path = NULL)
    {
        return new static(new MyDotCnfFileConnectionProvider($path ?: $_ENV['HOME'].'/.my.cnf'));
    }

    /**
     * @param DatabaseConnectionProvider $connection
     */
    public function __construct(DatabaseConnectionProvider $connection)
    {
        $this->connection = $connection;
        $this->setErrorReporting();
    }

    /**
     * Ensure that regardless of all server configuration, phinx never swallows errors or warnings
     */
    public function setErrorReporting()
    {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', TRUE);
        set_error_handler(
            function ($severity, $message, $file, $line) {
                throw new \ErrorException($message." [$file:$line]", 0, $severity, $file, $line);
            }
        );
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function getConfig(array $options)
    {
        $conn         = $this->connection->getConnectionInfo();
        $conn['name'] = $options['database_name'];

        return [
            'paths'                => [
                'migrations' => '%%PHINX_CONFIG_DIR%%/db_schema/migrations',
            ],
            'environments'         => [
                'default_migration_table' => 'phinx_migrations',
                'default'                 => $conn,
            ],
            'migration_base_class' => IngeneratorBaseMigration::class,
            'templates'            => [
                'file' => realpath(__DIR__.'/../templates/default_migration.php.txt'),
            ],
        ];
    }

}
