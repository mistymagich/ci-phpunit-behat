<?php
use Behat\Behat\Context\BehatContext,
Behat\Behat\Exception\PendingException,
Behat\Behat\Exception\UndefinedException,
Behat\Behat\Event\FeatureEvent;

use Guzzle\Http\Client,
    Guzzle\Http\Exception\ClientErrorResponseException;

include_once dirname(__FILE__) . '/../bootstrap.php';

class UsersApiFeatureContext extends BehatContext
{
    private static $databaseTester;
    private $client;
    private $request;
    private $response;
    private $data = array();

    public static function getConnection()
    {
        include APPPATH.'config/development/database.php';
        $dsn = sprintf('mysql:host=%s;dbname=%s', $db['default']['hostname'], $db['default']['database']);
        $pdo = new PDO($dsn, $db['default']['username'], $db['default']['password'], array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $db['default']['char_set']
        ));

        return self::createDefaultDBConnection($pdo, '');
    }

    protected static function getDataSet()
    {
        $ds1 = new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            TESTS_DIR . "fixtures/sample.yml"
        );

        return $ds1;
    }

    protected static function createDefaultDBConnection(PDO $connection, $schema = '')
    {
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($connection, $schema);
    }

    protected static function getDatabaseTester()
    {
        if (empty(self::$databaseTester)) {
            self::$databaseTester = self::newDatabaseTester();
        }

        return self::$databaseTester;
    }

    protected static function newDatabaseTester()
    {
        return new PHPUnit_Extensions_Database_DefaultTester(self::getConnection());
    }

    protected static function getSetUpOperation()
    {
        return PHPUnit_Extensions_Database_Operation_Factory::CLEAN_INSERT();
    }

    protected static function getTearDownOperation()
    {
        return PHPUnit_Extensions_Database_Operation_Factory::NONE();
    }

    /** @BeforeFeature */
    public static function setupFeature(FeatureEvent $event)
    {
        self::$databaseTester = NULL;
        self::getDatabaseTester()->setSetUpOperation(self::getSetUpOperation());
        self::getDatabaseTester()->setDataSet(self::getDataSet());
        self::getDatabaseTester()->onSetUp();
    }

    /** @AfterFeature */
    public static function teardownFeature(FeatureEvent $event)
    {
        self::getDatabaseTester()->setTearDownOperation(self::getTearDownOperation());
        self::getDatabaseTester()->setDataSet(self::getDataSet());
        self::getDatabaseTester()->onTearDown();
        self::$databaseTester = NULL;
    }

    /**
     * @Given /^ベースURLは "([^"]*)"$/
     */
    public function url($arg1)
    {
        $this->client = new Client($arg1);
    }

    /**
     * @Given /^"([^"]*)" に "([^"]*)" リクエスト$/
     */
    public function stepDefinition1($arg1, $arg2)
    {
        $method = strtolower($arg2);
        switch ($method) {
        case 'get':
        case 'post':
        case 'put':
        case 'delete':
            $this->request = $this->client->$method($arg1, null, $this->data);
            break;
        default:
            new UndefinedException("Undefined HTTP method: $method");
        }

        try {
            $this->response = $this->request->send();
        } catch (ClientErrorResponseException $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @Given /^ステータスコードは "([^"]*)" を返す$/
     */
    public function vBi($arg1)
    {
        $code = $this->response->getStatusCode();
        if ($code != $arg1) {
            throw new ErrorException("Undefined Code: $code");
        }
    }

    /**
     * @Given /^レスポンスデータは "([^"]*)" 形式$/
     */
    public function v($arg1)
    {
        if (!$this->response->json()) {
            throw new ErrorException('Invalid JSON format');
        }
    }

    /**
     * @Given /^レスポンスデータは "([^"]*)" がセットされている$/
     */
    public function v2($arg1)
    {
        $data = $this->response->json();

        switch ($arg1) {
        case 'ユーザ一覧情報':
            $data = $data[0];
        case 'ユーザ情報':
            if (!isset($data['id'])) {
                throw new ErrorException('Invalid Format');
            }

            break;
        default:
            throw new UndefinedException("Undefined $arg1");
        }
    }

    /**
     * @Given /^パラメータ "([^"]*)" に "([^"]*)" をセット$/
     */
    public function v3($arg1, $arg2)
    {
        $this->data[$arg1] = $arg2;
    }

    /**
     * @Given /^レスポンスヘッダに "([^"]*)" がある$/
     */
    public function stepDefinition2($arg1)
    {
        $header = $this->response->getHeader($arg1);
        if (!$header) {
            throw new ErrorException("$arg1 not found");
        }
    }

    /**
     * @Given /^レスポンスデータはなにもない$/
     */
    public function v5()
    {
        if ($this->response->getContentLength() != 0) {
            throw new ErrorException('data exists');
        }
    }

}
