<?php

class Bug0001Test extends CI_PHPUnit_Framework_TestCase {
    public function testSuccessTest() {
        $this->assertEquals(1,1);
    }

    public function testFailureTest() {
        $this->assertEquals(1,2);
    }
}
