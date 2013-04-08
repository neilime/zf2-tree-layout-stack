<?php
namespace TreeLayoutStack;
class Module implements \Zend\ModuleManager\Feature\AutoloaderProviderInterface{

	/**
	 * @param \Zend\EventManager\EventInterface $oEvent
	 */
	public function onBootstrap(\Zend\EventManager\EventInterface $oEvent){
		$oServiceManager = $oEvent->getApplication()->getServiceManager();

		//Attach templating service to render event
		if($oServiceManager->has('ViewRenderer') && $oServiceManager->get('ViewRenderer') instanceof \Zend\View\Renderer\PhpRenderer)$oEventManager->attach(
			\Zend\Mvc\MvcEvent::EVENT_RENDER,
			array($oServiceManager->get('TemplatingService'), 'onRender')
		);
	}

	/**
	 * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
	 * @return array
	 */
	public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            )
        );
    }

    /**
     * @return array
     */
    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }
}