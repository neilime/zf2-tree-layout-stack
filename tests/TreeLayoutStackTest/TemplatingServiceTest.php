<?php
namespace TreeLayoutStackTest;
class TemplatingServiceTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \BoilerAppDisplay\Service\TemplatingService
	 */
	protected $templatingService;

	public function setUp(){
		$this->templatingService = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService');
	}

	public function testGetConfiguration(){
		$this->assertInstanceOf('\BoilerAppDisplay\Service\TemplatingConfiguration',$this->templatingService->getConfiguration());
	}

	public function testGetSharedManager(){
		$this->assertInstanceOf('\Zend\EventManager\SharedEventManagerInterface',$this->templatingService->getSharedManager());
	}

	public function testUnsetSharedManager(){
		$this->assertInstanceOf('\BoilerAppDisplay\Service\TemplatingService',$this->templatingService->unsetSharedManager());
	}

	public function testBuildLayoutTemplate(){
		$oEvent = new \Zend\Mvc\MvcEvent(\Zend\Mvc\MvcEvent::EVENT_RENDER);
		$oEvent->setRequest(new \Zend\Http\Request());
		$oRenderer = new \Zend\View\Renderer\PhpRenderer();
		$oEvent->setViewModel(new \Zend\View\Model\ViewModel());
		$this->assertInstanceOf('\BoilerAppDisplay\Service\TemplatingService',$this->templatingService->buildLayoutTemplate($oEvent));
	}
}