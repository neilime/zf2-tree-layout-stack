<?php
namespace TreeLayoutStackTest;
class TemplatingServiceTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\TemplatingService
	 */
	protected $templatingService;

	public function setUp(){
		$oTemplatingServiceFactory = new \TreeLayoutStack\Factory\TemplatingServiceFactory();
		$this->templatingService = $oTemplatingServiceFactory->createService(\TreeLayoutStackTest\Bootstrap::getServiceManager());
	}

	public function testGetConfiguration(){
		$this->assertInstanceOf('\TreeLayoutStack\TemplatingConfiguration',$this->templatingService->getConfiguration());
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetConfigurationUnset(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\TemplatingService');
		$oConfiguration = $oReflectionClass->getProperty('configuration');
		$oConfiguration->setAccessible(true);
		$oConfiguration->setValue($this->templatingService,null);
		$this->templatingService->getConfiguration();
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetCurrentEventUnset(){
		$oReflectionClass = new \ReflectionClass('\TreeLayoutStack\TemplatingService');
		$oGetCurrentEvent = $oReflectionClass->getMethod('getCurrentEvent');
		$oGetCurrentEvent->setAccessible(true);
		$oGetCurrentEvent->invoke($this->templatingService);
	}

	public function testBuildLayoutTemplate(){
		$oEvent = new \Zend\Mvc\MvcEvent(\Zend\Mvc\MvcEvent::EVENT_RENDER);
		$oViewModel = new \Zend\View\Model\ViewModel();
		\TreeLayoutStackTest\Bootstrap::getServiceManager()->get('viewhelpermanager')->get('view_model')->setRoot($oViewModel);

		//Test return
		$this->assertInstanceOf('\TreeLayoutStack\TemplatingService',$this->templatingService->buildLayoutTemplate($oEvent
			->setRequest(new \Zend\Http\Request())
			->setViewModel($oViewModel)
		));

		//Test view model
		$this->assertInstanceOf('Zend\View\Model\ViewModel',$oEvent->getViewModel());

		//Test rendering
		$oRenderer = new \Zend\View\Renderer\PhpRenderer();
		$oRenderer
			->setResolver(\TreeLayoutStackTest\Bootstrap::getServiceManager()->get('ViewResolver'))
			->setHelperPluginManager(\TreeLayoutStackTest\Bootstrap::getServiceManager()->get('viewhelpermanager'));

		$this->assertEquals(file_get_contents(__DIR__.'/../_files/expected/rendering.phtml'),$oRenderer->render($oEvent->getViewModel()));
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testBuildLayoutTemplateWithWrongTemplate(){
		$oEvent = new \Zend\Mvc\MvcEvent(\Zend\Mvc\MvcEvent::EVENT_RENDER);
		$oViewModel = new \Zend\View\Model\ViewModel();
		\TreeLayoutStackTest\Bootstrap::getServiceManager()->get('viewhelpermanager')->get('view_model')->setRoot($oViewModel);

		$this->templatingService->buildLayoutTemplate($oEvent
			->setRequest(new \Zend\Http\Request())
			->setRouteMatch(new \Zend\Mvc\Router\RouteMatch(array('controller' => 'Wrong\Controller')))
			->setViewModel($oViewModel)
		);
	}
}