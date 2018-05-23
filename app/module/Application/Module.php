<?php namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Admin\Model\Category;
use Admin\Model\Service;
use Application\Model\Customeroptions;
use Application\Model\CustomeroptionsTable;
use Application\Model\Customerdelivery;
use Application\Model\CustomerdeliveryTable;
use Application\Model\UseruploadedfileTable;
use Application\Model\Useruploadedfile;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;

class Module
{
     
	  public function onBootstrap($e)
    {
        $app = $e->getApplication();
        $em  = $app->getEventManager(); // Specific event manager from App
        $sem = $em->getSharedManager(); // The shared event manager
		$sem->attach(__NAMESPACE__, 'dispatch', function($e) {
        $controller = $e->getTarget();
        $route = $controller->getEvent()->getRouteMatch();
		$app = $e->getApplication();
		$sm =  $app->getServiceManager();
		$router   = $e->getRouter();
		$productoptions = $sm->get('Admin\Model\ProefdrukOptionNameTable');
		$proof_id =0;
		
     	// an id must always be availble
     	
     	if(!$route->getParam('id')) {
     		echo "Er is iets fouts gegaan"; 
			exit;
     	} else {
     		// check if the proof status is 0 that is  accepted...
     		// otherwise send the user back..
     		$proof = $sm->get('Admin\Model\ProefdrukTable');
			$proof_id = (int) base64_decode($route->getParam('id'));
			$proefdruk = $proof->getProefdruk($proof_id);
			$options = $productoptions->getOptionsWithValues(0,false,$proof_id);
			
			if(count($options)==0) {
				if($proefdruk->proof_size_customer == 1) {
					$options = true;
				} else {
					$options = false;
				}
				
			} else  {
				$options = true;
			}
			
			if($proefdruk->proof_status!=0 && $route->getParam('action', 'index')!="index") {
				$url      = "/proefdruk/index/".$proof_id;
		        $response = $e->getResponse();
		        $response->getHeaders()->addHeaderLine('Location', $url);
		        $response->setStatusCode(302);
			}
     	}
		 $e->getViewModel()->setVariables(
            array('controllerName'=> $route->getParam('controller','index'),
                'actionName' => $route->getParam('action', 'index'),
                'options'=>$options,
                'proof_id'=>$proof_id,
                'proof_number'=>$proefdruk->proof_number,'proof_date'=>$proefdruk->proof_date,'proof_amount'=>$proefdruk->proof_amount,
                'moduleName' => strtolower(__NAMESPACE__))
        );
		
    }, 100);
		
		
		
    } 
	
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	
	 public function getServiceConfig()
    {
        return array(
            'factories' => array(

				'Application\Model\Customeroptions' =>  function($sm) {
                    $tableGateway = $sm->get('CustomeroptionsTableGateWay');
                    $table = new  CustomeroptionsTable($tableGateway); 
                    return $table;
                },
                'Application\Model\Customerdelivery' =>  function($sm) {
                    $tableGateway = $sm->get('CustomerdeliveryTableGateWay');
                    $table = new  CustomerdeliveryTable($tableGateway); 
                    return $table;
                },
                'Application\Model\Useruploadedfile' =>  function($sm) {
                    $tableGateway = $sm->get('UseruploadedfileTableGateWay');
                    $table = new  UseruploadedfileTable($tableGateway); 
                    return $table;
                },
                
				
				
             
				'CustomeroptionsTableGateWay' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new Customeroptions());
	                return new TableGateway('admin_customer_options', $dbAdapter, null, $resultSetPrototype);
                },
                
				'UseruploadedfileTableGateWay' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new Useruploadedfile());
	                return new TableGateway('user_uploaded_files', $dbAdapter, null, $resultSetPrototype);
                },
                
				'CustomerdeliveryTableGateWay' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	                $resultSetPrototype = new ResultSet();
	                $resultSetPrototype->setArrayObjectPrototype(new Customerdelivery());
	                return new TableGateway('admin_customer_delivery', $dbAdapter, null, $resultSetPrototype);
                },
               
               

				
			
			 
		        
				
				
            ),
        );
    }


}