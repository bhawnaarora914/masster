<?php
return array(
'service_manager' => array(
    'factories' => array(
        'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
    ),
),

    'controllers' => array(
        'invokables' => array(
             'proefdruk' => 'Admin\Controller\ProefdrukController',
             'login' => 'Admin\Controller\LoginController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
        // add here another route
			'proefdruk' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/proefdruk[/:action][/:id]',
	                'constraints' => array(
	                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
	                     'id'     => '[0-9]+',
	                ),
                    'defaults' => array(
                        'controller' => 'proefdruk',
                        'action'     => 'index',
                        
                    )
                ),
            ),
            
			'login' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/administrator[/:action]',
                     'constraints' => array(
	                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
	                    ),
                    'defaults' => array(
                        'controller' => 'login',
                        'action'     => 'index',
                        
                    )
                ),
            ),
      
            
        )
		),
         
			 
  
	
	
	
	

    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
             'admin/layout'           => __DIR__ . '../../view/layout/layout.phtml',
             'admin/header'           => __DIR__ . '../../view/layout/general/header.phtml',
             'admin/footer'           => __DIR__ . '../../view/layout/general/footer.phtml',
             'admin/loginheader'           => __DIR__ . '../../view/layout/general/header_login.phtml',
             'admin/topnav'           => __DIR__ . '../../view/layout/general/topnav.phtml'
        ),
        
    ),
    
	
	
		
   
    
); 