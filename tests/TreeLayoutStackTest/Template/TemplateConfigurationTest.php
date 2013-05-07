<?php
namespace TreeLayoutStackTest\Template;
class TemplateConfigurationTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\Template\TemplateConfiguration
	 */
	protected $templateConfiguration;
	protected $originalTemplate;
	protected $originalChildren;

	public function setUp(){
		$this->templateConfiguration = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration()->getLayoutTreeForModule()->getConfiguration();
		$this->originalTemplate = $this->templateConfiguration->getTemplate();
		$this->originalChildren = $this->templateConfiguration->getChildren();
	}

	public function testGetTemplate(){
		$this->assertEquals('layout/layout',$this->templateConfiguration->getTemplate());
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetTemplateUnset(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\Template\TemplateConfiguration');
		$oTemplate = $oReflectionClass->getProperty('template');
		$oTemplate->setAccessible(true);
		$oTemplate->setValue($this->templateConfiguration,null);
		$this->templateConfiguration->getTemplate();
	}

	public function testGetChildren(){
		$aChildren = $this->templateConfiguration->getChildren();

		$this->assertTrue(is_array($aChildren));
		$this->assertArrayHasKey('header',$aChildren);
		$this->assertArrayHasKey('footer',$aChildren);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetChildrenUnset(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\Template\TemplateConfiguration');
		$oChildren = $oReflectionClass->getProperty('children');
		$oChildren->setAccessible(true);
		$oChildren->setValue($this->templateConfiguration,null);
		$this->templateConfiguration->getChildren();
	}

	public function tearDown(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\Template\TemplateConfiguration');

		//Reset template
		$oTemplate = $oReflectionClass->getProperty('template');
		$oTemplate->setAccessible(true);
		$oTemplate->setValue($this->templateConfiguration,$this->originalTemplate);

		//Reset children
		$oChildren = $oReflectionClass->getProperty('children');
		$oChildren->setAccessible(true);
		$oChildren->setValue($this->templateConfiguration,$this->originalChildren);
	}
}