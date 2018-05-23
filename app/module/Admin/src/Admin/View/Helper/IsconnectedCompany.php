<?php namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;  
 
class IsconnectedCompany extends AbstractHelper implements ServiceLocatorAwareInterface  
{
      
    public function __invoke($debtor_id,$form_att_id)  
    {  
         $sm = $this->getServiceLocator()->getServiceLocator();
		 $ConnectedCompany =  $sm->get("Admin\Model\ConnectedCompanyTable");
		 return $ConnectedCompany->getConnectedCompanies($debtor_id,$form_att_id);
		
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