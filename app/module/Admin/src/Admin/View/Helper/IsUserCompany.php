<?php namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;  
 
class IsUserCompany extends AbstractHelper implements ServiceLocatorAwareInterface  
{
      
    public function __invoke($id)  
    {  
         $sm = $this->getServiceLocator()->getServiceLocator();
		 $User =  $sm->get("Admin\Model\UserTable");
		 $userdata = $User->getUser('',$id);
		
		 if($userdata->debtor_id!=0) {
		 	return $userdata->debtor_id;
		 } else {
		 	return false;
		 }
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