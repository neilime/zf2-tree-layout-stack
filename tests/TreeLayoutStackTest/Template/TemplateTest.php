<?php
namespace TreeLayoutStackTest\Template;
class TemplateTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\Template\Template
	 */
	protected $template;

	protected $templateConfiguration;

	public function setUp(){
		$this->template = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration()->getLayoutTreeForModule();
		$this->templateConfiguration = $this->template->getConfiguration();
	}

	public function testGetConfiguration(){
		$this->assertInstanceOf('\TreeLayoutStack\Template\TemplateConfiguration',$this->template->getConfiguration());
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetConfigurationUnset(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\Template\Template');

		$oConfiguration = $oReflectionClass->getProperty('configuration');
		$oConfiguration->setAccessible(true);
		$oConfiguration->setValue($this->template,null);

		$this->template->getConfiguration();
	}

	public function testGetChildren(){
		$aChildren = $this->template->getChildren();

		$this->assertTrue(is_array($aChildren));
		$this->assertArrayHasKey('header',$aChildren);
		$this->assertArrayHasKey('footer',$aChildren);
		$this->assertInstanceOf('\TreeLayoutStack\Template\Template',$aChildren['header']);
		$this->assertInstanceOf('\TreeLayoutStack\Template\Template',$aChildren['footer']);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetChildrenWithWrongConfiguration(){

		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\Template\Template');

		$oChildren = $oReflectionClass->getProperty('children');
		$oChildren->setAccessible(true);
		$oChildren->setValue($this->template,null);


		$oConfiguration = $this->template->getConfiguration();
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\Template\TemplateConfiguration');

		$oChildren = $oReflectionClass->getProperty('children');
		$oChildren->setAccessible(true);
		$oChildren->setValue($oConfiguration,array('wrong' => new \stdClass()));

		$this->template->getChildren();
	}

	public function tearDown(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\Template\Template');

		$oConfiguration = $oReflectionClass->getProperty('configuration');
		$oConfiguration->setAccessible(true);
		$oConfiguration->setValue($this->template,$this->templateConfiguration);
	}
}