<?php

/**
 * CI_PHPUnit_Framework_TestCase
 */
class CI_PHPUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{
    protected $CI;

    public function setUp()
    {
        parent::setUp();

        $this->CI = &get_instance();
    }
}
