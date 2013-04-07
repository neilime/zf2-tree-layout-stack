<?php
namespace TreeLayoutStackTest;
class TemplatingConfigurationTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \BoilerAppDisplay\Service\TemplatingConfiguration
	 */
	protected $templateConfiguration;

	public function setUp(){
		$this->templateConfiguration = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration();
	}

	public function testGetTemplateMapForModule(){
		$this->assertInstanceOf('\BoilerAppDisplay\Service\Template\Template',$this->templateConfiguration->getTemplateMapForModule());
	}

	public function testHasTemplateMapForModule(){
		$this->assertTrue($this->templateConfiguration->hasTemplateMapForModule());
		$this->assertFalse($this->templateConfiguration->hasTemplateMapForModule('UnknownModule'));
	}
}