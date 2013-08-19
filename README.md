TreeLayoutStack, v1.0
=======

[![Build Status](https://travis-ci.org/neilime/zf2-tree-layout-stack.png?branch=master)](https://travis-ci.org/neilime/zf2-tree-layout-stack)
[![Latest Stable Version](https://poser.pugx.org/neilime/zf2-tree-layout-stack/v/stable.png)](https://packagist.org/packages/neilime/zf2-tree-layout-stack)
[![Total Downloads](https://poser.pugx.org/neilime/zf2-tree-layout-stack/downloads.png)](https://packagist.org/packages/neilime/zf2-tree-layout-stack)
![Code coverage](https://raw.github.com/zf2-boiler-app/app-test/master/ressources/100%25-code-coverage.png "100% code coverage")

NOTE : If you want to contribute don't hesitate, I'll review any PR.

Introduction
------------

TreeLayoutStack is module for ZF2 allowing the creation of tree layout 

Requirements
------------

* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)

Installation
------------

### Main Setup

#### By cloning project

1. Clone this project into your `./vendor/` directory.

#### With composer

1. Add this project in your composer.json:

    ```json
    "require": {
        "neilime/zf2-tree-layout-stack": "dev-master"
    }
    ```
2. Now tell composer to download TreeLayoutStack by running the command:

    ```bash
    $ php composer.phar update
    ```

#### Post installation

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'TreeLayoutStack',
        ),
        // ...
    );
    ```
# How to use _TreeLayoutStack_

## Simple configuration example

This example shows how to define a simple tree layout stack with header and footer parts

1. After installing skeleton application, install _TreeLayoutStack_ as explained above.

2. Edit the application module configuration file `module/Application/config/module.config.php`, adding the configuration fragment below:
	
	```php
	<?php
	return array(
		//...
		'tree_layout_stack' => array(
	    	'layout_tree' => array(
				'default' => array(
					'template' => 'layout/layout',
					'children' => array(
						'header' => 'header/header',
						'footer' => 'footer/footer'										
					)
				)
			)
	    ),
	    //...
		'view_manager' => array(
			'template_map' => array(
				//...
				'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
				'header/logged' => __DIR__ . '/../view/layout/header.phtml',
				'footer/footer' => __DIR__ . '/../view/layout/footer.phtml'
				//...
			)
		)
	    //...
	);
	
3. Edit layout file `module/Application/view/layout/layout.phtml`, adding header and footer where you want to display them
	```php	 
		//...
		echo $this->header; //Display header part
		//...
		
		//...
		echo $this->layout()->content; //Display content part
		//...
		
		//...
		echo $this->layout()->footer; //Display footer part
		//...	
    ```
    
3. Create header and footer view files
	`module/Application/view/layout/header.phtml`
	`module/Application/view/layout/footer.phtml`

5. Save & Resfresh.

# Configuration

1. _TreeLayoutStack_ :

 * array `layout_tree`: Define the layout tree, you can define differents tree layout stack, depends on module name, the `default` configuration is used if no template is defined for current module 
 
2. Module layout tree map (`layout_tree` entry) :

 * string|array|callable template : define the template name
 * array children : (optionnal) define children of the template, the configuration is the same as the `layout_tree` entry or `template`
 
 
## Complexe exemple

This example shows all the configuration options available, it assume that `template_map` is properly defined in `view_manager` configuration

	```php
	<?php
	return array(
		//...
		'tree_layout_stack' => array(
	    	'layout_tree' => array(
				'default' => array(
					'template' => 'layout/layout',
					'children' => array(
						'header' => function(\Zend\Mvc\MvcEvent $oEvent){
							return $oEvent->getViewModel()->isLoggedUser?'header/logged':'header/unlogged' // Current MVC event is passed as argument to the callable template
						},
						'footer' => array(
							'template' => 'footer/footer',
							'children' => array(
								'social' => 'footer/social',
								'sitemap' => array('SampleClass','SampleFunction') //Sample callback
							)
						)									
					)
				)
			)
	    ),
	    //...
	);
	```