<?php

declare(strict_types=1);

/**
 * Abstract Factory classes
 */
abstract class DBAbstractionFactory
{
    protected array $settings = [];

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    abstract public function createInstance(): void;
}

class PDOAbstractionFactory extends DBAbstractionFactory
{
    private PDO $db;

    public function createInstance(): void
    {
        $this->db = new PDO($this->settings['db.dsn']);
    }
}

class DBAbstractionFactoryADODB extends DBAbstractionFactory
{
    private ADONewConnection $db;

    public function createInstance(): void
    {
        require_once('/path/to/adodb_lite/adodb.inc.php');
        $this->db = ADONewConnection($this->settings['db.dsn']);
    }
}

class DBAbstractionFactoryMDB2 extends DBAbstractionFactory
{
    private MDB2 $db;

    public function createInstance(): void
    {
        require_once 'MDB2.php';
        $db = MDB2::factory($this->settings['db.dsn']);
    }
}

class DBAbstractionAbstractFactory
{
    public static function getFactory(array $settings): DBAbstractionFactory
    {
        switch($settings['db.library'])
        {
            case 'adodblite':
                $factory = new DBAbstractionFactoryADODBLITE($settings);
                break;
            case 'mdb2';
                $factory = new DBAbstractionFactoryMDB2($settings);
                break;
            case 'pdo';
                $factory = new PDOAbstractionFactory($settings);
                break;
            default:
                throw new \Exception(
                    sprintf('DB library %d not found', $settings['db.library'])
                );
        }

        return $factory;
    }
}

/**
 * Client's code
 */

$settings = [
    'db.library' => 'pdo',
    'db.dsn' => 'mysql:host=localhost;dbname=test'
];

// instantiate Abstract Factory
$abstractfactory = new DBAbstractionAbstractFactory();

// fetch a concrete Factory (decision handled in Abstract Factory static method)
$factory = $abstractfactory::getFactory($settings);

// use concrete Factory to create a database connection object from
// the selected database abstraction library
$factory->createInstance();