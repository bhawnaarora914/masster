<?php
namespace Admin;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ViewHelperProviderInterface;  


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Admin\Model\User;
use Admin\Model\UserTable;
use Admin\Model\Proefdruk;
use Admin\Model\ProefdrukTable;
use Admin\Model\ProefdrukOptionName;
use Admin\Model\ProefdrukOptionNameTable;
use Admin\Model\ProefdrukOptionsValues;
use Admin\Model\ProefdrukOptionValuesTable;
use Admin\Model\Extrafile;
use Admin\Model\ExtrafileTable;
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ViewHelperProviderInterface
{
	
	
	 
	  public function onBootstrap($e)
    {
        $app = $e->getApplication();
        $em  = $app->getEventManager(); // Specific event manager from App
        $sem = $em->getSharedManager(); // The shared event manager
       
        $sem->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function($e) {
            $controller = $e->getTarget(); // The controller which is dispatched
            $controller->layout('admin/layout'); // zet de default login voor de controller
        });
		
	
		$sem->attach(__NAMESPACE__, 'dispatch', function($e) {
        $controller = $e->getTarget();
        $route = $controller->getEvent()->getRouteMatch();

		$app = $e->getApplication();
		$sm =  $app->getServiceManager();
		$auth = $sm->get('AuthService');
		$router   = $e->getRouter();
      // check authorisation
		// all via the bootstrap...
		
		if($auth->hasIdentity()==false) {
			if($route->getParam('controller','index')!="login") {
				// Redirect to the user login page, as an example
	              $url      = "/app/proefdruk/administrator";
		        $response = $e->getResponse();
		        $response->getHeaders()->addHeaderLine('Location', $url);
		        $response->setStatusCode(302);
	            return $response;
			}
		} 
	
 
        $e->getViewModel()->setVariables(
            array('controllerName'=> $route->getParam('controller','index'),
                'actionName' => $route->getParam('action', 'index'),
                'username' => $auth->getIdentity(),
                'moduleName' => strtolower(__NAMESPACE__))
        );
    }, 100);
		
		
		
    } 
	

	
      public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
	
	public function getViewHelperConfig()
    {
        return array();
   }
	
	
    public function getServiceConfig()
    {
        return array(
            'factories' => array(

                'Admin\Model\UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new  UserTable($tableGateway); 
                    return $table;
                },
                
				'Admin\Model\ExtrafileTable' =>  function($sm) {
                    $tableGateway = $sm->get('ExtraFileTableGateWay');
                    $table = new  ExtrafileTable($tableGateway); 
                    return $table;
                },
                
				'Admin\Model\ProefdrukTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProefdrukTableGateWay');
                    $table = new  ProefdrukTable($tableGateway); 
                    return $table;
                },
                
				'Admin\Model\ProefdrukOptionNameTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProefdrukOptionNameTableGateWay');
                    $table = new  ProefdrukOptionNameTable($tableGateway); 
                    return $table;
                },
                
				'Admin\Model\ProefdrukOptionValuesTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProefdrukOptionValuesTableGateWay');
                    $table = new  ProefdrukOptionValuesTable($tableGateway); 
                    return $table;
                },
                
				
                'ExtraFileTableGateWay' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new Extrafile());
	                return new TableGateway('admin_extrafile', $dbAdapter, null, $resultSetPrototype);
                },
                
				'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new User());
	                return new TableGateway('admin_user', $dbAdapter, null, $resultSetPrototype);
                },
                
				
				'ProefdrukTableGateWay' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new Proefdruk());
	                return new TableGateway('admin_proefdruk', $dbAdapter, null, $resultSetPrototype);
                },
                
				
                'ProefdrukOptionNameTableGateWay' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new ProefdrukOptionName());
	                return new TableGateway('admin_proefdruk_option_name', $dbAdapter, null, $resultSetPrototype);
                },
                
				'ProefdrukOptionValuesTableGateWay' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new ProefdrukOptionsValues());
	                return new TableGateway('admin_proefdruk_option_values', $dbAdapter, null, $resultSetPrototype);
                },
               
               

				
				'AuthService' => function($sm) {
           			 $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
               		 $dbTableAuthAdapter  = new AuthAdapter($dbAdapter,
                                              'admin_user','username','password','MD5(?)');
	            	$authService = new AuthenticationService();
		            $authService->setAdapter($dbTableAuthAdapter);
		            return $authService;
	       	 },
	       	 
			 
		        
				
				
            ),
        );
    }
	
	
}