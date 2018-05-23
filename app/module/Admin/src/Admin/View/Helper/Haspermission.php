<?php namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;  
 
class Haspermission extends AbstractHelper implements ServiceLocatorAwareInterface  
{
      
    public function __invoke($id,$resource)  
    {  
         $sm = $this->getServiceLocator()->getServiceLocator();
		 $Permission =  $sm->get("Admin\Model\PermissionTable");
		 return $Permission->hasPermission($id,$resource);
		
    }  
	
	
	 /** 
     * Set the service locator. 
     * 
     * @param ServiceLocatorInterface $serviceLocator 
     * @return CustomHelper 
     */  
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)  
    {  
        $this->serviceLocator = $serviceLocator;  
        
    }  
    /** 
     * Get the service locator. 
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface 
     */  
    public function getServiceLocator()  
    {  
        return $this->serviceLocator;  
    }  
	
	
	
}