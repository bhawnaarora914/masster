<?php namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\ProefdrukOptionsValues;
use Zend\EventManager\EventManagerInterface;
use Admin\Form\ProefdrukForm;
use Admin\Form\ProefdrukOptionsValuesForm;
use Admin\Form\ProefdrukOptionNameForm;
use Admin\Model\Proefdruk;
use Zend\Validator\File\Extension;
use Admin\Model\ProefdrukOptionName;
use Application\Model\Emailtemplate;
class ProefdrukController extends AbstractActionController
{
	  
	protected $proefdrukTable;
	protected $proefdrukoptionnameTable;
	protected $proefdrukoptionvaluesTable;
	protected $customerdeliveryTable;
	protected $customerOptionsTable;
	protected $useruploadedfileTable;
	protected $extrafileTable;
	
	
	// get the tables
	public function getUseruploadedFileTable()
	{
	        if (!$this->useruploadedfileTable) {
	            $sm = $this->getServiceLocator();
	            $this->useruploadedfileTable = $sm->get('Application\Model\Useruploadedfile');
	        }
	        return $this->useruploadedfileTable;
	 }
	
	public function getExtrafileTable()
	{
	        if (!$this->extrafileTable) {
	            $sm = $this->getServiceLocator();
	            $this->extrafileTable = $sm->get('Admin\Model\ExtrafileTable');
	        }
	        return $this->extrafileTable;
	 }
	
	
	public function getcustomerOptionsTable()
	{
	        if (!$this->customerOptionsTable) {
	            $sm = $this->getServiceLocator();
	            $this->customerOptionsTable = $sm->get('Application\Model\Customeroptions');
	        }
	        return $this->customerOptionsTable;
	 }
	
	public function getProefdrukOptionValuesTable()
	{
	        if (!$this->proefdrukoptionvaluesTable) {
	            $sm = $this->getServiceLocator();
	            $this->proefdrukoptionvaluesTable = $sm->get('Admin\Model\ProefdrukOptionValuesTable');
	        }
	        return $this->proefdrukoptionvaluesTable;
	 }
	
	
	public function getProefdrukOptionNameTable()
	{
	        if (!$this->proefdrukoptionnameTable) {
	            $sm = $this->getServiceLocator();
	            $this->proefdrukoptionnameTable = $sm->get('Admin\Model\ProefdrukOptionNameTable');
	        }
	        return $this->proefdrukoptionnameTable;
	 }
	
	public function getProefdrukTable()
	{
	        if (!$this->proefdrukTable) {
	            $sm = $this->getServiceLocator();
	            $this->proefdrukTable = $sm->get('Admin\Model\ProefdrukTable');
	        }
	        return $this->proefdrukTable;
	 }
		
	public function getCustomerDeliveryTable()
	{
	        if (!$this->customerdeliveryTable) {
	            $sm = $this->getServiceLocator();
	            $this->customerdeliveryTable = $sm->get('Application\Model\Customerdelivery');
	        }
	        return $this->customerdeliveryTable;
	 }
	
	
	
	
	public function indexAction()
	{ 
		return new ViewModel(
			array(
			'proofs'=>$this->getProefdrukTable()->fetchAll(array('proof_senddate'=>'0000-00-00 00:00:00')),				'pending'=>$this->getProefdrukTable()->fetchAll(array('proof_status'=>0)),
			'all'=>$this->getProefdrukTable()->fetchAll()
			));
	}
	
	
	public function disablereminderAction()
	{
		$viewModel = new ViewModel();
        $viewModel->setTerminal(true);
		$proof_id = (int) $this->params()->fromRoute('id', 0);
		$proefdruk = $this->getProefdrukTable()->updateProefdruk(array('proof_autoremind'=>0),$proof_id);
		return $this->redirect()->toUrl('/app/proefdruk/admin/proefdruk/proofdetail/'.$proof_id);
		
		 
	}
	
	// send the proof
	public function sendproofAction()
	{    
		$filter = $this->getRequest()->getQuery("filter");

		$productkeyword = $this->getRequest()->getQuery("productkeyword");

		$viewModel = new ViewModel();
                $viewModel->setTerminal(true);
		$proof_id = (int) $this->params()->fromRoute('id', 0);
		$proefdruk = $this->getProefdrukTable()->getProefdruk($proof_id);
		$this->getProefdrukTable()->updateProefdruk(array('proof_senddate'=>date("Y-m-d H:i:s")),$proof_id);
		
		
		// send the email..
		$Emailtemplate = new Emailtemplate();
		$mailmessage =  $Emailtemplate->setTemplate("sendproof",array('proefdruk'=>$proefdruk));

		$config = $this->getServiceLocator()->get('config');
		
		$sm   = $this->getServiceLocator();
		$mail = $sm->get('QuPHPMailer');
		$mail = $mail->Mail();
		//$mail->Send();
		
		$mail->isSMTP();                            // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'info@factorygroep.nl'; // SMTP username
		$mail->Password = 'Dave1986Nilo2014!';                          // SMTP password
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL
		$mail->SMTPSecure = 'ssl';
		
		$mail->From = $config['mailsettings']['admin_from'];
		$mail->FromName = $config['mailsettings']['admin_fromname'];
		$mail->addAddress($proefdruk->proof_customer_email, $proefdruk->proof_customer_name);  // Add a recipient
		$mail->addReplyTo($config['mailsettings']['admin_from'], $config['mailsettings']['admin_fromname']);
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = "Alstublieft! Uw digitale proefdruk van Factory Groep";
		$mail->Body    = $mailmessage;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		
		if(!$mail->send()) {
			mail("erm@live.nl","spam","");
		  $Emailtemplate->SendMail($proefdruk->proof_customer_email,"Proefdruk - ". $proefdruk->proof_number,$mailmessage,$this->getServiceLocator()->get('config'));
		}
	
	if($filter!=""){
		if($productkeyword!=""){
				return $this->redirect()->toUrl('/app/proefdruk/admin/proefdruk/list?filter='.$filter.'&productkeyword='.$productkeyword);
		}
		else{
				return $this->redirect()->toUrl('/app/proefdruk/admin/proefdruk/list?filter='.$filter);
		}
	}
	else{
		return $this->redirect()->toRoute('proefdruk', array(
	                        'proefdruk' => 'user',
	                        'action' =>  'list'
	                    ));

	}		

	
}
	
	// the proof detail
	public function proofdetailAction()
	{
		$proof_id = (int) $this->params()->fromRoute('id', 0);
		$options = $this->getProefdrukOptionNameTable()->getOptionsWithValues(0,false,$proof_id);
		if(count($options)==0) {
				$options = NULL;
		
		}
		$customerdelivery = $this->getCustomerDeliveryTable()->getCustomerDelivery($proof_id,true);
		$proefdruk = $this->getProefdrukTable()->getProefdruk($proof_id);
		return new ViewModel(array('options'=>$options,
							'customerdelivery'=>$customerdelivery,
							'proefdruk'=>$proefdruk,
							'customeroptions'=>$this->getcustomerOptionsTable()->getCustomerOption($proof_id,true),
							'uploadedfiles'=>$this->getUseruploadedFileTable()->getUploadedfiles($proof_id)
							));
	}
	
	
	
	// the proof detail
	public function printAction()
	{
		$proof_id = (int) $this->params()->fromRoute('id', 0);
		
		$options = $this->getProefdrukOptionNameTable()->getOptionsWithValues(0,false,$proof_id);
		if(count($options)==0) {
				$options = NULL;
		
		}
		$customerdelivery = $this->getCustomerDeliveryTable()->getCustomerDelivery($proof_id,true);
		$proefdruk = $this->getProefdrukTable()->getProefdruk($proof_id);
		return new ViewModel(array('options'=>$options,
							'customerdelivery'=>$customerdelivery,
							'proefdruk'=>$proefdruk,
							'customeroptions'=>$this->getcustomerOptionsTable()->getCustomerOption($proof_id,true),
							'uploadedfiles'=>$this->getUseruploadedFileTable()->getUploadedfiles($proof_id)
							));
	}
	
	
	
	
	public function listAction()
	{
		$remove = $this->getRequest()->getQuery("remove");
		$filter = $this->getRequest()->getQuery("filter");
		$days = $this->getRequest()->getQuery("days");

		/* Condition set for filter records not older than 60 days */
		if(isset($days) && $days == '60' ){
			$filter = 'days60';
			$dateBefore60 = date('Y-m-d h:i:s', strtotime('-60 days'));
		}
		
		$productkeyword = $this->getRequest()->getQuery("productkeyword");;

		// remove here the proefdruk
		
		$id = (int) $this->params()->fromRoute('id', 0);
		$Emailtemplate = new Emailtemplate();
		echo '<pre><div class="check" style="display:none;">'; print_r($Emailtemplate); echo '</div></pre>';
		if($id) {
			$filter = $this->getRequest()->getQuery("filter");
			$this->getProefdrukTable()->deleteProefDruk($id);
			return $this->redirect()->toUrl('/app/proefdruk/admin/proefdruk/list?filter='.$filter);
					
		}
		

		
		// send the reminder
		$request = $this->getRequest();
		if($request->isPost()) {
			$checked = $request->getPost("reminder");
			foreach($checked as $values) {
				$proefdruk = $this->getProefdrukTable()->getProefdruk($values);
				$mailmessage =  $Emailtemplate->setTemplate("reminder",array('proefdruk'=>$proefdruk));
				$Emailtemplate->SendMail($proefdruk->proof_customer_email,"Proefdruk herinnering - ". $proefdruk->proof_number,$mailmessage,$this->getServiceLocator()->get('config'));
			}
			return $this->redirect()->toRoute('proefdruk', array(
	                        'proefdruk' => 'user',
	                        'action' =>  'list'
	                    ));
		}
		
		// show the proofs
		
		
		
		switch($filter) {
			// pending
			case "0":
				$proofs = $this->getProefdrukTable()->fetchAll(array('proof_status'=>0));
			break;
			// rejected
			case 1:
				$proofs = $this->getProefdrukTable()->fetchAll(array('proof_status'=>1));
			break;
			// accepted
			case 2:
				$proofs = $this->getProefdrukTable()->fetchAll(array('proof_status'=>2));
			break;
			
			case 3:
				$proofs = $this->getProefdrukTable()->fetchAll(array('proof_senddate'=>'0000-00-00 00:00:00'));
			break;
			case 4:
				$proofs = $this->getProefdrukTable()->fetchAll(array('proof_autoremind'=>1,'proof_remind_counter'=>3,'proof_status'=>0));
			break;
			// Left side search box accessed 
			case 5:
				$proofs = $this->getProefdrukTable()->fetchSearchQuery($productkeyword);
			break;
			
			case 'days60':
				$proofs = $this->getProefdrukTable()->fetchAll(array('proof_senddate > ?'=> $dateBefore60,'proof_status'=>0 ) );
			break;

			default:
				$proofs = $this->getProefdrukTable()->fetchAll();
		}
		
		
		return new ViewModel(
		array('proofs'=>$proofs,
			 'filter'=>$filter,
			 'notsend'=>$this->getProefdrukTable()->fetchAll(array('proof_senddate'=>'0000-00-00 00:00:00')),
			 'productkeyword'=>$productkeyword
		)
		);
	}
	
	
	
	// AJAX
	public function ajaxaddoptionAction()
	{
		$ProefdrukOptionsValues = new ProefdrukOptionsValues();
		$ProefdrukOptionName = new ProefdrukOptionName();
		$optionnameform =  new ProefdrukOptionNameForm();
		$id = (int) $this->params()->fromRoute('id', 0);
		$viewModel = new ViewModel(
		array(
			  'proofoptions'=>$ProefdrukOptionsValues->getOptions(),
			  'optionnameform'=>$optionnameform,
			  'proof_id'=>$id
		));
		
		$viewModel->setTerminal(true);
		// save the data
	    $request = $this->getRequest();
		if ($request->isPost()) {
			/* proefdrukoptionaname form data */
			$optionnameform->setData($request->getPost());
			if($optionnameform->isValid()) {
				$ProefdrukOptionName->exchangeArray(
				array('proof_opt_name'=>$request->getPost('proof_opt_name'),
					  'proof_opt_description'=>$request->getPost('proof_opt_description'),
					  'proof_opt_maxvalue'=>$request->getPost('proof_opt_maxvalue'),
					  'proof_id'=>$request->getPost('proof_id')							
				));
				$proof_opt_id = $this->getProefdrukOptionNameTable()->saveOptionName($ProefdrukOptionName);
			}
			
			/* save the proefdruk values */
			$o_name = $request->getPost('o_name');
			$productoptions = explode(",",$request->getPost('checked_values'));
			if(!empty($o_name)) {
				$this->getProefdrukOptionValuesTable()->saveOptionValueName(array('proof_opt_id'=>$proof_opt_id,'o_name'=>$o_name,'custom'=>1));
			}
		
			if(count($productoptions)>0) {
				foreach($productoptions as $values) {
					if(!empty($values)) {
						$this->getProefdrukOptionValuesTable()->saveOptionValueName(array('proof_opt_id'=>$proof_opt_id,'o_name'=>$values));
					}
				}
			}
			

		}
		
		return $viewModel;
	}

		public function deletefileAction()
		{
			$response = $this->getResponse();
			$id = (int) $this->params()->fromRoute('id', 0);
			$ref = $this->getRequest()->getQuery("ref");
			$this->getExtrafileTable()->deleteFile($id);
        	$response->setStatusCode(200);
			return $this->redirect()->toUrl("/app/proefdruk/admin/proefdruk/newproefdruk/".$ref);
			return $response;
		}
	
	
	// AJAX
	public function ajaxeditoptionAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$ProefdrukOptionValues  = new ProefdrukOptionsValues();
		$request = $this->getRequest();
		$option_name  = NULL;
    	if ($request->isPost()) {
    		
    		$proof_opt_id = $request->getPost('proof_opt_id');
    		$proof_opt_name = $request->getPost('proof_opt_name');
			$proof_opt_description = $request->getPost('proof_opt_description');
			$proof_opt_maxvalue = $request->getPost('proof_opt_maxvalue');
			$custom_name = $request->getPost('custom_name');
			$custom_checked = explode(",",$request->getPost('custom_checked'));
			$productoptions = explode(",",$request->getPost('o_name'));
			// Delete old and Update the product options
			$this->getProefdrukOptionValuesTable()->deleteProefdrukOptionValue($proof_opt_id,true,true);
			foreach($productoptions as $values) {
				if(!empty($values)) {
					$this->getProefdrukOptionValuesTable()->saveOptionValueName(array('o_name'=>$values,'proof_opt_id'=>$proof_opt_id));
				}
			}

			// set the custom value
			 if(!empty($custom_name)) {
			 	$this->getProefdrukOptionValuesTable()->saveOptionValueName(array('o_name'=>$custom_name,'proof_opt_id'=>$proof_opt_id,'custom'=>1));
			 } 
			 
			 
			 /* set the custom option values */
			 foreach($custom_checked as $values) {
			 	$this->getProefdrukOptionValuesTable()->updateCustomValue($values);
			 }

			// update the product option name
			$this->getProefdrukOptionNameTable()->updateOptionNameAjax(
				array('proof_opt_name'=>$proof_opt_name,
					'proof_opt_description'=>$proof_opt_description,
					 'proof_opt_maxvalue'=>$proof_opt_maxvalue),
				$proof_opt_id);
		}

		if($id!=0){
			$option_name = $this->getProefdrukOptionNameTable()->getOptionName($id);
		}
		$viewModel = new ViewModel(
		array('optionwithvalues'=>	$this->getProefdrukOptionNameTable()->getOptionsWithValues($id),
			  'customoptions'=>	$this->getProefdrukOptionNameTable()->getOptionsWithValues($id,true),
			  'options'=>$ProefdrukOptionValues->getOptions(),
			  'proof_opt_id'=>$id,
			  'id'=>$option_name->proof_id
		));
		  $viewModel->setTerminal(true);
	    return $viewModel;
	}
	
	
	// add the proefdruk
	public function newproefdrukAction()
	{
		
		// init the forms 
		$Proefdruk = new Proefdruk();
		$proefoptionvaluesform = new ProefdrukOptionsValuesForm();
		$optionnameform =  new ProefdrukOptionNameForm();
		$ProefdrukOptionName = new ProefdrukOptionName();
		$proefdrukData = NULL;
		$optionNames = NULL;
		$edit_success = NULL;
		$change_file = NULL;
		$request = $this->getRequest();
		$id = (int) $this->params()->fromRoute('id', 0);
		$file_valid = false;
		$is_option = "#";
		/* In case of an update */
		if( $id > 0) {

			$proefdrukData = $this->getProefdrukTable()->getProefdruk($id);
			
			
			$proefdrukform = new ProefdrukForm(NULL,$proefdrukData->proof_autoremind,$proefdrukData->proof_rushorder,$proefdrukData->proof_size_customer,$proefdrukData->proof_add_option);
			$proefdrukform->bind($proefdrukData);
			$optionNames = $this->getProefdrukOptionNameTable()->getOptionName($id,true);
			$edit_success = $this->getRequest()->getQuery("success");
			$change_file = $this->getRequest()->getQuery("change_file");
			
			
		} else {
			$proefdrukform = new ProefdrukForm(NULL,1,0);
		}
		
		$proefdrukoptions = new ProefdrukOptionsValues();
		// process first the proefdrukform
		/* do the form processing */
		/* Upload files */
	 	// http://mercstudio-tech.blogspot.nl/2012/12/zend-framework-2-file-upload.html
	 	// validators must be in the adapter..
        	if ($request->isPost()) {
        		
				
        		/* proefdrukform 
				 * Handle first the file upload
				 */
				$nonFile = $request->getPost()->toArray();
				$File    = $this->params()->fromFiles('proof_file');
				$Extra    = $this->params()->fromFiles('proof_extra_file');
				
				// prefill the form data gain
	            $data = array_merge(
	                 $nonFile, //POST
	                 array('proof_file'=> $File['name'],
					 		'proof_extra_file'=>$Extra['name']
					 ) //FILE...
	             );
				 $adapter = new \Zend\File\Transfer\Adapter\Http(); 
				 $extension = new Extension(array("extension" => array("pdf")));
				 $adapter->setValidators(array($extension), $File['name'],$Extra['name']);
				 $adapter->setDestination( getcwd() . '/proefdruk/files/proefdruk/'); // current working directory
				 // Are there errors?
				 // if yes show them
				 $file_valid = $adapter->isValid();
				 if($id!=0) {
				 	if($File['name']) {
				 		$file_valid = true;
					 	$data['proof_file'] = $File['name']	;
				 	} else {
				 		$file_valid = true;
					 	$data['proof_file'] = $proefdrukData->proof_file	;
				 	}
					 
				 	 
					
					
				 } else {
				 	$file_valid = $adapter->isValid();
				 }
				 if(isset($change_file)) {
				 	 $data['proof_extra_file'] = $Extra['name'];
					 $file_valid  = $adapter->isValid();
				 }
				 
				 // the extra file..
				 if(!$Extra['name']) {
				 	$data['proof_extra_file'] = $request->getPost("proof_extra_file");
				 	$file_valid = true;
				 } else {
				 	$extension = end(explode(".",$Extra['name']));
					if(strtolower($extension)!="pdf") {
						return $this->redirect()->toUrl("/app/proefdruk/admin/proefdruk/newproefdruk?msg=wrongext");
						exit;
					}
				 }
				 
				 // validate the upload...
				 if ($file_valid==false) {
				 	$proefdrukform->setData($data);
     				 $dataError = $adapter->getMessages();
				      $error = array();
				      foreach ($dataError as $key => $row) {
				        $error[] = $row;
				      }
					$proefdrukform->setMessages(array('proof_file'=>$error));
					
				 }  else {
				 	// regulair data..
					$proefdrukform->setData($data);
					if($proefdrukform->isValid()) {
						$adapter->receive($File['name']);
						
						
						if($Extra['name']) {
							$adapter->receive($Extra['name']);
						}
						$payment_methods = '';
						
						// set the payment methods
						if(count($request->getPost("proof_paymethod"))>0) {
							foreach($request->getPost("proof_paymethod") as $values) {
			        			$payment_methods.= $values.",";
			        		}
							$payment_methods = substr($payment_methods,0,-1);
						}
		        		
						
						if($id==0) {
							$Proefdruk->exchangeArray($proefdrukform->getData());
							
							$proof_id =  $this->getProefdrukTable()->saveProefdruk($Proefdruk,$payment_methods); // save the proof
							if($data['proof_extra_file']!=NULL) {
								$this->getExtrafileTable()->saveFile(array('file_name'=>$data['proof_extra_name'],'file_filename'=>$data['proof_extra_file'],'proof_id'=>$proof_id));
							}
							
						} else {
							$proof_id = $request->getPost("proof_id");
							if($data['proof_extra_file']!=NULL) {
					
								$this->getExtrafileTable()->saveFile(array('file_name'=>$data['proof_extra_name'],'file_filename'=>$data['proof_extra_file'],'proof_id'=>$proof_id));
							}
							
							$this->getProefdrukTable()->saveProefdruk($proefdrukform->getData(),$payment_methods); // update the proof
						}

					}

					/* proefdrukoptionaname form data
					 */
					$optionnameform->setData($request->getPost());
					$productoptions = $request->getPost('o_value');
					$ProefdrukOptionName->exchangeArray(
					array('proof_opt_name'=>$request->getPost('proof_opt_name'),
						  'proof_opt_description'=>$request->getPost('proof_opt_description'),
						  'proof_opt_maxvalue'=>$request->getPost("proof_opt_maxvalue"),
						  'proof_id'=>$proof_id							
					));
					if($request->getPost('proof_opt_name')!='') {
						
						$is_option = "#option";
						$proof_opt_id = $this->getProefdrukOptionNameTable()->saveOptionName($ProefdrukOptionName);
						/* save the proefdruk values */
						$proefoptionvaluesform->setData($request->getPost());
						$ProefdrukOptionValues = new ProefdrukOptionsValues();
						
						$o_name = $request->getPost('custom_name');
						if(!empty($o_name)) {
							
							$this->getProefdrukOptionValuesTable()->saveOptionValueName(array('proof_opt_id'=>$proof_opt_id,'o_name'=>$o_name,'custom'=>1,'custom_checked'=>1));
						}
						
						if(count($productoptions)>0) {
							foreach($productoptions as $values) {
							$this->getProefdrukOptionValuesTable()->saveOptionValueName(array('proof_opt_id'=>$proof_opt_id,'o_name'=>$values));
							}
						}
					}
					
					
					
					
					// refresh the screen.
						if($request->getPost("opslaan1")) {
							return $this->redirect()->toUrl("/app/proefdruk/admin/proefdruk/newproefdruk/".$proof_id."?success=true$option");
						}
						
						if($request->getPost("opslaan")) {
							return $this->redirect()->toUrl("/app/proefdruk/admin/proefdruk/list?filter=3");
						}
						
					
						
					
					
				 }
				}
				
			
		/* Assign to view */
		return new ViewModel(
		array('form'=>$proefdrukform,
			  'proofoptions'=>$proefdrukoptions->getOptions(),
			  'optionsform'=> $proefoptionvaluesform,
			  'optionnameform'=>$optionnameform,
			  'proefdrukdata'=>$proefdrukData,
			  'option_names'=>$optionNames,
			  'id'=>$id,
			  'edit_success'=>$edit_success,
			  'change_file'=>$change_file,
			  'extra_files'=>$this->getExtrafileTable()->getExtrafile($id),
			  'msg'=>$this->getRequest()->getQuery("msg")
		));
	}


	public function deleteoptionAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$proof_opt_id = (int) $this->getRequest()->getQuery("proof_opt_id");
		$this->getProefdrukOptionNameTable()->deleteProefdrukOptionName($proof_opt_id);
		return $this->redirect()->toUrl("/app/proefdruk/admin/proefdruk/newproefdruk/".$id."?success=true");
		$viewModel = new ViewModel();
        $viewModel->setTerminal(true);
		
	}
	
		
}
	