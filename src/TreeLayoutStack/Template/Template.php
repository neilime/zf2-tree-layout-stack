<?php
namespace TreeLayoutStack\Template;
class Template{
	/**
	 * @var \TreeLayoutStack\Template\TemplateConfiguration
	 */
	protected $configuration;

	/**
	 * @var array
	 */
	protected $children;

	/**
	 * Constructor
	 */
	public function __construct(\TreeLayoutStack\Template\TemplateConfiguration $oConfiguration){
		$this->configuration = $oConfiguration;
	}

	/**
	 * @throws \LogicException
	 * @return \TreeLayoutStack\Template\TemplateConfiguration
	 */
	public function getConfiguration(){
		if($this->configuration instanceof \TreeLayoutStack\Template\TemplateConfiguration)return $this->configuration;
		throw new \LogicException('Configuration is undefined');
	}

	/**
	 * @throws \LogicException
	 * @return array
	 */
	public function getChildren(){
		if(!is_array($this->children)){
			$this->children = array();
			foreach($this->getConfiguration()->getChildren() as $sChildrenName => $oChildrenConfiguration){
				if(!is_string($sChildrenName))throw new \LogicException('Children Name expects string, '.gettype($sChildrenName).' given');
				if($oChildrenConfiguration instanceof \Traversable)$oChildrenConfiguration = \Zend\Stdlib\ArrayUtils::iteratorToArray($oChildrenConfiguration);

				if(is_array($oChildrenConfiguration))$oChildrenConfiguration = new \TreeLayoutStack\Template\TemplateConfiguration($oChildrenConfiguration);
				elseif(is_string($oChildrenConfiguration) || is_callable($oChildrenConfiguration))$oChildrenConfiguration = new \TreeLayoutStack\Template\TemplateConfiguration(array(
					'template' => $oChildrenConfiguration
				));
				if(!($oChildrenConfiguration instanceof \TreeLayoutStack\Template\TemplateConfiguration))throw new \LogicException(sprintf(
					'% expects an array, Traversable object, string or \TreeLayoutStack\Template\TemplateConfiguration object ; received "%s"',
					__METHOD__,
					(is_object($oChildrenConfiguration)?get_class($oChildrenConfiguration):gettype($oChildrenConfiguration))
				));
				$this->children[$sChildrenName] = new \TreeLayoutStack\Template\Template($oChildrenConfiguration);
			}
		}
		return $this->children;
	}
}