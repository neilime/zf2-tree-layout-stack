<?php
namespace TreeLayoutStackTest;
class TemplatingConfigurationTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\TemplatingConfiguration
	 */
	protected $templateConfiguration;

	public function setUp(){
		$this->templateConfiguration = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration();
	}

	public function testGetTemplateMapForModule(){
		$this->assertInstanceOf('\TreeLayoutStack\Template\Template',$this->templateConfiguration->getLayoutTreeForModule());
	}

	public function testHasTemplateMapForModule(){
		$this->assertTrue($this->templateConfiguration->hasLayoutTreeForModule());
		$this->assertFalse($this->templateConfiguration->hasLayoutTreeForModule('UnknownModule'));
	}
}