<?php
namespace TreeLayoutStackTest\Template;
class TemplateConfigurationTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \BoilerAppDisplay\Service\Template\TemplateConfiguration
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
		$this->assertArrayHasKey('specialLayout',$aChildren);
		$this->assertArrayHasKey('template',$aChildren['specialLayout']);
		$this->assertArrayHasKey('children',$aChildren['specialLayout']);
	}
}