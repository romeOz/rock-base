<?php

namespace rockunit;


use rock\base\BaseException;

class BaseExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertExceptionToString()
    {
        $this->assertContains('test exception', BaseException::convertExceptionToString(new \Exception('test exception')));
    }

    public function testConvertExceptionToError()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        BaseException::convertExceptionToError(new \Exception('test exception'));
    }
}
