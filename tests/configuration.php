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
	'view_manager' => array(
		'doctype' => 'HTML5'
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
	'templating' => array(
		'template_map' => array(
			'default' => array(
				'template' => 'layout/layout',
				'children' => array(
					'specialLayout' => array(
						'template' => 'layout/default',
						'children' => array(
							'header' => function(){
								return 'header/logged';
							},
							'footer' => 'footer/footer'
						)
					)
				)
			)
		)
	),
	'view_manager' => array(
		'template_map' => array(
			'layout/layout' => __DIR__ . '/_files/view/layout/layout.phtml',
			'layout/default' => __DIR__ . '/_files/view/layout/default.phtml',
			'header/logged' => __DIR__ . '/_files/view/application/header/logged.phtml',
			'footer/footer' => __DIR__ . '/_files/view/application/footer/footer.phtml'
		)
	)
);