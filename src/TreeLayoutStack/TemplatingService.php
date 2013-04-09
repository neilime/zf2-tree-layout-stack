<?php
namespace TreeLayoutStack;
class TemplatingService{
	/**
	 * @var \TreeLayoutStack\TemplatingConfiguration
	 */
	protected $configuration;

	/**
	 * @var \Zend\Mvc\MvcEvent
	 */
	protected $currentEvent;

	/**
	 * Constructor
	 * @param \TreeLayoutStack\TemplatingConfiguration $oConfiguration
	 */
	private function __construct(\TreeLayoutStack\TemplatingConfiguration $oConfiguration = null){
		if($oConfiguration)$this->setConfiguration($oConfiguration);
	}

	/**
	 * Instantiate a Templating service
	 * @param array|Traversable $aOptions
	 * @throws \InvalidArgumentException
	 * @return \TreeLayoutStack\TemplatingService
	 */
	public static function factory($aOptions){
		if($aOptions instanceof \Traversable)$aOptions = \Zend\Stdlib\ArrayUtils::iteratorToArray($aOptions);
		elseif(!is_array($aOptions))throw new \InvalidArgumentException(__METHOD__.' expects an array or Traversable object; received "'.(is_object($aOptions)?get_class($aOptions):gettype($aOptions)).'"');
		return new static(new \TreeLayoutStack\TemplatingConfiguration($aOptions));
	}

	/**
	 * @param \TreeLayoutStack\TemplatingConfiguration $oConfiguration
	 * @return \TreeLayoutStack\TemplatingService
	 */
	public function setConfiguration(\TreeLayoutStack\TemplatingConfiguration $oConfiguration){
		$this->configuration = $oConfiguration;
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return \TreeLayoutStack\TemplatingConfiguration
	 */
	public function getConfiguration(){
		if($this->configuration instanceof \TreeLayoutStack\TemplatingConfiguration)return $this->configuration;
		throw new \LogicException('Configuration is undefined');
	}

	/**
	 * @param \Zend\Mvc\MvcEvent $oEvent
	 * @return \TreeLayoutStack\TemplatingService
	 */
	protected function setCurrentEvent(\Zend\Mvc\MvcEvent $oEvent){
		$this->currentEvent = $oEvent;
		return $this;
	}

	/**
	 * @return \TreeLayoutStack\TemplatingService
	 */
	protected function unsetCurrentEvent(){
		$this->currentEvent = null;
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return \Zend\Mvc\MvcEvent
	 */
	protected function getCurrentEvent(){
		if($this->currentEvent instanceof \Zend\Mvc\MvcEvent)return $this->currentEvent;
		throw new \LogicException('Current event is undefined');
	}

	/**
	 * Define layout template
	 * @param \Zend\Mvc\MvcEvent $oEvent
	 * @throws \RuntimeException
	 * @return \TreeLayoutStack\TemplatingService
	 */
	public function buildLayoutTemplate(\Zend\Mvc\MvcEvent $oEvent){
		$oRequest = $oEvent->getRequest();
		if(!($oRequest instanceof \Zend\Http\Request) || $oRequest->isXmlHttpRequest() || (
    		($oView = $oEvent->getResult()) instanceof \Zend\View\Model\ModelInterface
    		&& $oView->terminate()
    	))return $this;

		//Define current event
		$this->setCurrentEvent($oEvent);

		//Define module Name

		/* @var $oRouter \Zend\Mvc\Router\RouteMatch */
		if(($oRouter = $this->getCurrentEvent()->getRouteMatch()) instanceof \Zend\Mvc\Router\RouteMatch)$sModule = current(explode('\\',$oRouter->getParam('controller')));
		if(empty($sModule))$sModule = \TreeLayoutStack\TemplatingConfiguration::DEFAULT_LAYOUT_TREE;

		try{
			//Retrieve template for module
			$oTemplate = $this->getConfiguration()->hasLayoutTreeForModule($sModule)
				?$this->getConfiguration()->getLayoutTreeForModule($sModule)
				:$this->getConfiguration()->getLayoutTreeForModule(\TreeLayoutStack\TemplatingConfiguration::DEFAULT_LAYOUT_TREE);

			//Set layout template and add its children
			$sTemplate = $oTemplate->getConfiguration()->getTemplate();
			if(is_callable($sTemplate))$sTemplate = $sTemplate($this->getCurrentEvent());
			$oEvent->setViewModel($this->setChildrenToView(
				$oEvent->getViewModel()->setTemplate($sTemplate),
				$oTemplate->getChildren()
			));
		}
		catch(\Exception $oException){
			throw new \RuntimeException('Error occured during building layout template process : '.$oException->getMessage(),$oException->getCode(),$oException);
		}
		//Reset current event
		return $this->unsetCurrentEvent();
	}

	/**
	 * @param \Zend\View\Model\ViewModel $oParentView
	 * @param array $aChildren
	 * @return \Zend\View\Model\ViewModel
	 */
	protected function setChildrenToView(\Zend\View\Model\ViewModel $oParentView, array $aChildren){
		foreach($aChildren as $sChildrenName => $oChildrenTemplate){
			$sTemplate = $oChildrenTemplate->getConfiguration()->getTemplate();
			if(is_callable($sTemplate))$sTemplate = $sTemplate($this->getCurrentEvent());

			$oParentView->addChild(
				$this->setChildrenToView(
					new \Zend\View\Model\ViewModel(),
					$oChildrenTemplate->getChildren()
				)->setTemplate($sTemplate),
				$sChildrenName
			);
		}
		return $oParentView;
	}
}