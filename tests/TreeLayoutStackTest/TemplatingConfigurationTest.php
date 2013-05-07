<?php
namespace TreeLayoutStackTest;
class TemplatingConfigurationTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\TemplatingConfiguration
	 */
	protected $templatingConfiguration;

	public function setUp(){
		$this->templatingConfiguration = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService')->getConfiguration();
	}

	public function testGetTemplateMapForModule(){
		$this->assertInstanceOf('\TreeLayoutStack\Template\Template',$this->templatingConfiguration->getLayoutTreeForModule());
	}

	public function testHasTemplateMapForModule(){
		$this->assertTrue($this->templatingConfiguration->hasLayoutTreeForModule());
		$this->assertFalse($this->templatingConfiguration->hasLayoutTreeForModule('UnknownModule'));
	}

	/**
	 * @expectedException LogicException
	 */
	public function testAddTemplateWithWrongConfiguration(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\TemplatingConfiguration');
		$oAddTemplate = $oReflectionClass->getMethod('addTemplate');
		$oAddTemplate->setAccessible(true);
		$oAddTemplate->invoke($this->templatingConfiguration,'wrong',new \stdClass());
	}
}