<?php
namespace TreeLayoutStackTest\Template;
class TemplateTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \BoilerAppDisplay\Service\Template\Template
	 */
	protected $template;

	public function setUp(){
		$this->template = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration()->getTemplateMapForModule();
	}

	public function testGetConfiguration(){
		$this->assertInstanceOf('\BoilerAppDisplay\Service\Template\TemplateConfiguration',$this->template->getConfiguration());
	}

	public function testGetChildren(){
		$aChildren = $this->template->getChildren();

		$this->assertTrue(is_array($aChildren));
		$this->assertArrayHasKey('specialLayout',$aChildren);
		$this->assertInstanceOf('\BoilerAppDisplay\Service\Template\Template',$aChildren['specialLayout']);
	}
}