<?php namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManagerInterface;
use Admin\Form\Adduserform;
use Admin\Model\User;
class LoginController extends AbstractActionController
{
	  protected $authservice;
	  protected $userTable;
	
	  
	  public function getAuthService()
    	{
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
        return $this->authservice;
   	 }
		
	public function getUserTable()
	{
	        if (!$this->userTable) {
	            $sm = $this->getServiceLocator();
	            $this->userTable = $sm->get('Admin\Model\UserTable');
	        }
	        return $this->userTable;
	 }
	
	
	
	
	
	public function indexAction()
	{
		
	// check if the user has been loged in
	 if ($this->getAuthService()->hasIdentity()==true){
            return $this->redirect()->toRoute('proefdruk', array(
                    'controller' => 'proefdruk',
                    'action' =>  'index'
                ));
        }
	 
		$request = $this->getRequest(); // do the request
		$valid_login = 1;
		// do the authentication
		if ($request->isPost()) {
			$username = $request->getPost("username");
			$password = $request->getPost("password");
			$this->getAuthService()->getAdapter()
                                   ->setIdentity($username)
                                  ->setCredential($password);
			$result = $this->getAuthService()->authenticate();
			$valid_login = $result->isValid();
			if($valid_login==true) {
				return $this->redirect()->toRoute('proefdruk', array(
	                        'controller' => 'proefdruk',
	                        'action' =>  'index'
	                    )); 
			}
		}
		 return new ViewModel(array(
            'valid_login' =>$valid_login));
       
	}




	public function logoutAction()
	{
		$viewModel = new ViewModel();
        $viewModel->setTerminal(true);
		$this->getAuthService()->clearIdentity();
		return $this->redirect()->toRoute('login');
		
	}
	
	public function listuserAction()
	{
		$user_id = (int) $this->getRequest()->getQuery("user_id");
		if($user_id!=0) {
			$this->getUserTable()->deleteUser($user_id);
			return $this->redirect()->toUrl('/app/proefdruk/administrator/listuser');
		}
		return new ViewModel(
			array('users'=>$this->getUserTable()->fetchAll())
		);
	}
	
	public function adduserAction()
	{
		$user_id = (int) $this->getRequest()->getQuery("user_id");
		$User = new User();
		$form = new Adduserform();
		if( $user_id > 0) {
			$userdata = $this->getUserTable()->getUser('',$user_id);
			$userdata->password ='';
			$form->bind($userdata);
		}
		/* do the form processing */
		 $request = $this->getRequest();
        	if ($request->isPost()) {
				$form->setData($request->getPost());
				if($form->isValid()) {
					// update
					if($user_id>0) {
					 	$this->getUserTable()->saveUser($form->getData());
						return $this->redirect()->toUrl("/app/proefdruk/administrator/listuser");
						 
					} else {
						//save
						$User->exchangeArray($form->getData());
						$this->getUserTable()->saveUser($User);
						return $this->redirect()->toUrl("/app/proefdruk/administrator/listuser");
					}
				}
			}
			
			return new ViewModel(array('form'=>$form,'user_id'=>$user_id));
		
	}
	
		
}
	