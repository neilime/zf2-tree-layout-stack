<?php
namespace TreeLayoutStack;
class TemplatingConfiguration extends \Zend\Stdlib\AbstractOptions{
	const DEFAULT_TEMPLATE_MAP = 'default';

	/**
	 * @var array
	 */
	protected $templateMap;

	/**
	 * @param array $aTemplateMap
	 * @return \TreeLayoutStack\TemplatingConfiguration
	 */
	public function setTemplateMap(array $aTemplateMap){
		foreach($aTemplateMap as $sModule => $oTemplateConfiguration){
			$this->addTemplate($sModule, $oTemplateConfiguration);
		}
		return $this;
	}

	/**
	 * @param string $sModule
	 * @throws \InvalidArgumentException
	 * @return \TreeLayoutStack\Template\Template
	 */
	public function getTemplateMapForModule($sModule = self::DEFAULT_TEMPLATE_MAP){
		if(!is_string($sModule))throw new \InvalidArgumentException('Module expects string, '.gettype($sModule).' given');
		if(!$this->hasTemplateMapForModule($sModule))throw new \InvalidArgumentException('Template Map is undefined for "'.$sModule.'"');
		return $this->templateMap[$sModule];
	}

	/**
	 * @param string $sModule
	 * @throws \InvalidArgumentException
	 * @return boolean
	 */
	public function hasTemplateMapForModule($sModule = self::DEFAULT_TEMPLATE_MAP){
		if(!is_string($sModule))throw new \InvalidArgumentException('Module expects string, '.gettype($sModule).' given');
		return isset($this->templateMap[$sModule]);
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
		$this->templateMap[$sModule] = new \TreeLayoutStack\Template\Template($oTemplateConfiguration);
		return $this;
	}
}