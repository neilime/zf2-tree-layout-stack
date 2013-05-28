<?php
namespace TreeLayoutStackTest;
class ModuleTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \TreeLayoutStack\Module
	 */
	protected $module;

	/**
	 * @var \Zend\Mvc\MvcEvent
	 */
	protected $event;

	public function setUp(){
		$this->module = new \TreeLayoutStack\Module();
		$aConfiguration = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('Config');

		$oApplication = \TreeLayoutStackTest\Bootstrap::getServiceManager()->get('Application');
		$oApplication->getServiceManager()->setAllowOverride(true)->setService('ViewRenderer', new \Zend\View\Renderer\PhpRenderer())->setAllowOverride(false);

		$this->event = new \Zend\Mvc\MvcEvent();
		$this->event
		->setViewModel(new \Zend\View\Model\ViewModel())
		->setApplication($oApplication)
		->setRouter(\Zend\Mvc\Router\Http\TreeRouteStack::factory(isset($aConfiguration['router'])?$aConfiguration['router']:array()))
		->setRouteMatch(new \Zend\Mvc\Router\RouteMatch(array('controller' => 'index','action' => 'index')));
	}

	public function testOnBootstrap(){
		$this->module->onBootstrap($this->event->setName(\Zend\Mvc\MvcEvent::EVENT_BOOTSTRAP));
	}

	public function testGetAutoloaderConfig(){
        $this->assertEquals(
        	array('Zend\Loader\ClassMapAutoloader' => array(realpath(getcwd().'/../autoload_classmap.php'))),
        	$this->module->getAutoloaderConfig()
        );
    }

    public function testGetConfig(){
    	$this->assertTrue(is_array($this->module->getConfig()));
    }
}