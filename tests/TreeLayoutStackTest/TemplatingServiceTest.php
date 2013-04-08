<?php
namespace TreeLayoutStackTest;
class TemplatingServiceTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\TemplatingService
	 */
	protected $templatingService;

	public function setUp(){
		$this->templatingService = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('TemplatingService');
	}

	public function testGetConfiguration(){
		$this->assertInstanceOf('\TreeLayoutStack\TemplatingConfiguration',$this->templatingService->getConfiguration());
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

		file_put_contents(__DIR__.'/../_files/expected/rendering.phtml', $oRenderer->render($oEvent->getViewModel()));
		$this->assertEquals(file_get_contents(__DIR__.'/../_files/expected/rendering.phtml'),$oRenderer->render($oEvent->getViewModel()));
	}
}