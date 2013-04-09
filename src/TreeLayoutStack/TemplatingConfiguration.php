<?php
namespace TreeLayoutStack;
class TemplatingConfiguration extends \Zend\Stdlib\AbstractOptions{
	const DEFAULT_LAYOUT_TREE = 'default';

	/**
	 * @var array
	 */
	protected $layoutTree;

	/**
	 * @param array $aLayoutTree
	 * @return \TreeLayoutStack\TemplatingConfiguration
	 */
	public function setLayoutTree(array $aLayoutTree){
		foreach($aLayoutTree as $sModule => $oTemplateConfiguration){
			$this->addTemplate($sModule, $oTemplateConfiguration);
		}
		return $this;
	}

	/**
	 * @param string $sModule
	 * @throws \InvalidArgumentException
	 * @return \TreeLayoutStack\Template\Template
	 */
	public function getLayoutTreeForModule($sModule = self::DEFAULT_LAYOUT_TREE){
		if(!is_string($sModule))throw new \InvalidArgumentException('Module expects string, '.gettype($sModule).' given');
		if(!$this->hasLayoutTreeForModule($sModule))throw new \InvalidArgumentException('Template Map is undefined for "'.$sModule.'"');
		return $this->layoutTree[$sModule];
	}

	/**
	 * @param string $sModule
	 * @throws \InvalidArgumentException
	 * @return boolean
	 */
	public function hasLayoutTreeForModule($sModule = self::DEFAULT_LAYOUT_TREE){
		if(!is_string($sModule))throw new \InvalidArgumentException('Module expects string, '.gettype($sModule).' given');
		return isset($this->layoutTree[$sModule]);
	}

	/**
	 * @param string $sModule
	 * @param \TreeLayoutStack\Template\TemplateConfiguration|\Traversable\array|string $aTemplateConfiguration
	 * @throws \InvalidArgumentException
	 * @return \TreeLayoutStack\TemplatingConfiguration
	 */
	protected function addTemplate($sModule, $oTemplateConfiguration){
		if(!is_string($sModule))throw new \InvalidArgumentException('Module expects string, '.gettype($sModule).' given');
		if($oTemplateConfiguration instanceof \Traversable)$oTemplateConfiguration = \Zend\Stdlib\ArrayUtils::iteratorToArray($oTemplateConfiguration);

		if(is_array($oTemplateConfiguration))$oTemplateConfiguration = new \TreeLayoutStack\Template\TemplateConfiguration($oTemplateConfiguration);
		elseif(is_string($oTemplateConfiguration) || is_callable($oTemplateConfiguration))$oTemplateConfiguration = new \TreeLayoutStack\Template\TemplateConfiguration(array(
			'template' => $oTemplateConfiguration
		));
		if(!($oTemplateConfiguration instanceof \TreeLayoutStack\Template\TemplateConfiguration))throw new \InvalidArgumentException(sprintf(
			'% expects an array, Traversable object, string or \TreeLayoutStack\Template\TemplateConfiguration object ; received "%s"',
			__METHOD__,
			(is_object($oTemplateConfiguration)?get_class($oTemplateConfiguration):gettype($oTemplateConfiguration))
		));
		$this->layoutTree[$sModule] = new \TreeLayoutStack\Template\Template($oTemplateConfiguration);
		return $this;
	}
}