<?php
namespace TreeLayoutStack\Template;
class TemplateConfiguration extends \Zend\Stdlib\AbstractOptions{
	/**
	 * @var string|callable
	 */
	protected $template;

	/**
	 * @var array
	 */
	protected $children = array();

	/**
	 * @param string|callable $sTemplate
	 * @throws \InvalidArgumentException
	 * @return \TreeLayoutStack\Template\TemplateConfiguration
	 */
	public function setTemplate($sTemplate){
		if(!is_string($sTemplate) && !is_callable($sTemplate))throw new \InvalidArgumentException('Template expects string or callable, '.gettype($sModule).' given');
		$this->template = $sTemplate;
		return $this;
	}

	/**
	 * @throws \InvalidArgumentException
	 * @return string|callable
	 */
	public function getTemplate(){
		if(is_string($this->template) || is_callable($this->template))return $this->template;
		throw new \InvalidArgumentException('Template is undefined');
	}

	/**
	 * @param array $aChildren
	 * @throws \Exception
	 * @return \TreeLayoutStack\Template\TemplateConfiguration
	 */
	public function setChildren(array $aChildren){
		$this->children = $aChildren;
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return array
	 */
	public function getChildren(){
		if(is_array($this->children))return $this->children;
		throw new \LogicException('Children are undefined');
	}
}