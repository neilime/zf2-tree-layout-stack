<?php
namespace TreeLayoutStackTest\Factory;
class TemplatingServiceFactoryTest extends \PHPUnit_Framework_TestCase{
    public function testCreateService(){
        $oTemplatingServiceFactory = new \TreeLayoutStack\Factory\TemplatingServiceFactory();
        $this->assertInstanceOf('\TreeLayoutStack\TemplatingService',$oTemplatingServiceFactory->createService(\TreeLayoutStackTest\Bootstrap::getServiceManager()));
    }
}