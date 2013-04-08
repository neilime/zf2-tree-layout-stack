<?php
namespace TreeLayoutStackTest\Template;
class TemplateConfigurationTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\Template\TemplateConfiguration
	 */
	protected $templateConfiguration;

	public function setUp(){
		$this->templateConfiguration = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration()->getTemplateMapForModule()->getConfiguration();
	}

	public function testGetTemplate(){
		$this->assertEquals('layout/layout',$this->templateConfiguration->getTemplate());
	}

	public function testGetChildren(){
		$aChildren = $this->templateConfiguration->getChildren();

		$this->assertTrue(is_array($aChildren));
		$this->assertArrayHasKey('header',$aChildren);
		$this->assertArrayHasKey('footer',$aChildren);
	}
}