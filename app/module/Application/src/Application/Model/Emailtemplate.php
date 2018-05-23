<?php namespace Application\Model;
use Zend\Mail\Message;
use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime as ZendMime;
class Emailtemplate
{
    private $template;
    private $message;
    
    public function setTemplate($template,$data)
    {
        $this->template = $template;
        $view = new \Zend\View\Renderer\PhpRenderer();
        $resolver = new \Zend\View\Resolver\TemplateMapResolver();
        $resolver->setMap(array(
                    'layout' => __DIR__ . '/../../../../Application/emailtemplate/'.$template.'.phtml'
            ));
        $view->setResolver($resolver);
        $viewModel = new \Zend\View\Model\ViewModel();
        $viewModel->setTemplate('layout')
            ->setVariables($data);     
        return $view->render($viewModel);
    }
    
    
    
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function SendMail($to,$subject,$body,$config=array(),$attachment=false,$filename='')
    {
        
        
        
        
        
        
        
        //$message = new Message();
        $message = new Message();
        $message->addFrom($config['mailsettings']['admin_from'], $config['mailsettings']['admin_fromname'])
        ->addTo($to)
        ->setSender($config['mailsettings']['admin_from'], $config['mailsettings']['admin_fromname'])
        ->addReplyTo($config['mailsettings']['admin_from'], $config['mailsettings']['admin_fromname'])
        ->setSubject($subject);
        $message->addReplyTo($config['mailsettings']['admin_from'], $config['mailsettings']['admin_fromname']);
        $message->getHeaders()->addHeaderLine('X-Mailer', 'PHP/'.phpversion());
        $message->getHeaders()->addHeaderLine('Content-Transfer-Encoding', '8bit');
        $message->getHeaders()->addHeaderLine('Content-type', 'text/html');
        $message->getHeaders()->addHeaderLine('MIME-Version', '1.0');
        $htmlPart = new MimePart($body);
        $htmlPart->type = "text/html";
        $body = new MimeMessage();
        
        if($attachment==true) {
            if($filename=='') {
                
            }
            $file = new MimePart(file_get_contents(getcwd()."/proefdruk/files/proefdruk/".$filename,"r"));
            $file->type = 'application/pdf';
            $file->filename=$filename;
            $file->encoding = ZendMime::ENCODING_BASE64;
            $file->disposition = ZendMime::DISPOSITION_ATTACHMENT;  
            $body->setParts(array($htmlPart,$file));
        } else {
            $body->setParts(array($htmlPart));
        }
        
        
        $message->setBody($body);
        $transport = new SmtpTransport();
         $transport = new Mail\Transport\Sendmail();
            $transport->send($message);
    }
    
    

}
