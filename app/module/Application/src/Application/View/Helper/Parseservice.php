<?php namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;  
 
class Parseservice extends AbstractHelper implements ServiceLocatorAwareInterface  
{
      
    public function __invoke($id)  
    {  
         $sm = $this->getServiceLocator()->getServiceLocator();
		 $Service =  $sm->get("Admin\Model\ServiceTable");
		 return $Service->getService($id,true);
		
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