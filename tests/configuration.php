<?php
return array(
	'router' => array(
		'routes' => array(
			'Home' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/'
				)
			)
		)
	),
	'translator' => array(
		'locale' => 'fr_FR',
		'translation_file_patterns' => array(
			array(
				'type' => 'phparray',
				'base_dir' => __DIR__.'/_files/translations/',
				'pattern'  => '%s.php'
			)
		)
	),
	'tree_layout_stack' => array(
		'layout_tree' => array(
			'default' => array(
				'template' => 'layout/layout',
				'children' => array(
					'header' => function(){
						return 'header/logged';
					},
					'footer' => 'footer/footer'
				)
			),
			'test' => 'layout/layout',
			'Wrong' => function(){
				throw new \Exception('Exception in template');
			}
		)
	),
	'view_manager' => array(
		'doctype' => 'HTML5',
		'template_map' => array(
			'layout/layout' => __DIR__ . '/_files/view/layout/layout.phtml',
			'header/logged' => __DIR__ . '/_files/view/application/header/logged.phtml',
			'footer/footer' => __DIR__ . '/_files/view/application/footer/footer.phtml'
		)
	)
);