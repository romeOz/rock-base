<?php
namespace rockunit;

class AliasTest extends \PHPUnit_Framework_TestCase
{
    public $aliases;

    protected function setUp()
    {
        parent::setUp();
        $this->aliases = \rock\base\Alias::$aliases;
    }

    protected function tearDown()
    {
        parent::tearDown();
        \rock\base\Alias::$aliases = $this->aliases;
    }

    public function test_()
    {
        \rock\base\Alias::$aliases = [];
        $this->assertSame('foo', \rock\base\Alias::getAlias('foo'));
        $this->assertFalse(\rock\base\Alias::getAlias('@rock', [], false));

        \rock\base\Alias::setAlias('@rock', '/rock/framework');
        $this->assertEquals('/rock/framework', \rock\base\Alias::getAlias('@rock'));
        $this->assertEquals('/rock/framework/test/file', \rock\base\Alias::getAlias('@rock/test/file'));
        \rock\base\Alias::setAlias('@rock/runtime', '/rock/runtime');
        $this->assertEquals('/rock/framework', \rock\base\Alias::getAlias('@rock'));
        $this->assertEquals('/rock/framework/test/file', \rock\base\Alias::getAlias('@rock/test/file'));
        $this->assertEquals('/rock/runtime', \rock\base\Alias::getAlias('@rock/runtime'));
        $this->assertEquals('/rock/runtime/file', \rock\base\Alias::getAlias('@rock/runtime/file'));

        \rock\base\Alias::setAlias('@rock.test', '@rock/test');
        $this->assertEquals('/rock/framework/test', \rock\base\Alias::getAlias('@rock.test'));

        // cascade
        \rock\base\Alias::setAlias('foo', '@rock/test');
        $this->assertEquals('/rock/framework/test', \rock\base\Alias::getAlias('@foo'));

        \rock\base\Alias::setAlias('@rock', null);
        $this->assertFalse(\rock\base\Alias::getAlias('@rock', [], false));
        $this->assertEquals('/rock/runtime/file', \rock\base\Alias::getAlias('@rock/runtime/file'));

        \rock\base\Alias::setAlias('@some/alias', '/www');
        $this->assertEquals('/www', \rock\base\Alias::getAlias('@some/alias'));

        // namespace
        \rock\base\Alias::setAlias('@rock.ns', '\rock\core');
        $this->assertEquals('\rock\core', \rock\base\Alias::getAlias('@rock.ns'));

        // set aliases
        \rock\base\Alias::setAliases(['@web' => '/assets', '@app' => '/apps/common']);
        $this->assertEquals('/assets', \rock\base\Alias::getAlias('@web'));
        $this->assertEquals('/apps/common', \rock\base\Alias::getAlias('@app'));

        $this->setExpectedException(get_class(new \Exception));
        \rock\base\Alias::getAlias('@rock');
    }
}