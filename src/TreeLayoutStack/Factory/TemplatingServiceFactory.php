<?php
namespace TreeLayoutStack\Factory;
class TemplatingServiceFactory implements \Zend\ServiceManager\FactoryInterface{
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
        //Configure the Templating service
        $aConfiguration = $oServiceLocator->get('Config');
       	return \TreeLayoutStack\TemplatingService::factory(isset($aConfiguration['templating'])?$aConfiguration['templating']:array());
    }
}