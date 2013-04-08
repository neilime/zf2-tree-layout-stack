<?php
namespace TreeLayoutStackTest\Template;
class TemplateTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\Template\Template
	 */
	protected $template;

	public function setUp(){
		$this->template = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration()->getTemplateMapForModule();
	}

	public function testGetConfiguration(){
		$this->assertInstanceOf('\TreeLayoutStack\Template\TemplateConfiguration',$this->template->getConfiguration());
	}

	public function testGetChildren(){
		$aChildren = $this->template->getChildren();

		$this->assertTrue(is_array($aChildren));
		$this->assertArrayHasKey('header',$aChildren);
		$this->assertArrayHasKey('footer',$aChildren);
		$this->assertInstanceOf('\TreeLayoutStack\Template\Template',$aChildren['header']);
		$this->assertInstanceOf('\TreeLayoutStack\Template\Template',$aChildren['footer']);
	}
}