<?php

class CI_PHPUnit_Extensions_Database_TestCase extends PHPUnit_Extensions_Database_TestCase
{
    protected $CI;

    public function setUp()
    {
        parent::setUp();

        $this->CI = &get_instance();
    }

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        include APPPATH.'config/' . ENVIRONMENT . '/database.php';
        $dsn = sprintf('mysql:host=%s;dbname=%s', $db['default']['hostname'], $db['default']['database']);
        $pdo = new PDO($dsn, $db['default']['username'], $db['default']['password'], array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $db['default']['char_set']
        ));

        return $this->createDefaultDBConnection($pdo);
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        $ds = new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            FCPATH . "fixtures/sample.yml"
        );

        return $ds;
    }

    public function testDummy()
    {
        $this->assertTrue(true);
    }
}
