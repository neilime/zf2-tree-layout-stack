<?php
namespace TreeLayoutStack;
class Module implements \Zend\ModuleManager\Feature\AutoloaderProviderInterface{

	/**
	 * @param \Zend\EventManager\EventInterface $oEvent
	 */
	public function onBootstrap(\Zend\EventManager\EventInterface $oEvent){
		$oServiceManager = $oEvent->getApplication()->getServiceManager();

		//Attach templating service to render event
		if(
			is_callable(array($oEvent,'getApplication'))
			&& ($oApplication = call_user_func(array($oEvent,'getApplication'))) instanceof \Zend\Mvc\Application
			&& ($oEventManager = $oApplication->getEventManager()) instanceof \Zend\EventManager\EventManagerInterface
			&& $oServiceManager->has('ViewRenderer')
			&& $oServiceManager->get('ViewRenderer') instanceof \Zend\View\Renderer\PhpRenderer
		)$oEventManager->attach(
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
                __DIR__.DIRECTORY_SEPARATOR.'autoload_classmap.php'
            )
        );
    }

    /**
     * @return array
     */
    public function getConfig(){
        return include __DIR__.DIRECTORY_SEPARATOR.'config/module.config.php';
    }
}