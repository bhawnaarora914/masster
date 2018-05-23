<?php namespace Application\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
 
class FileUploadForm extends Form
{
public function __construct($name = null, $options = array())
{
parent::__construct($name, $options);
 
$myFile = new Element\File('my-file');
$myFile
->setOptions(array())
->setLabel('Single File');
$this->add($myFile);
 
$multiFile = new Element\File('multi');
$multiFile
->setOptions(array())
->setLabel('Multi File');
 
$fileCollection = new Element\Collection('collection');
$fileCollection->setOptions(array(
'count' => 2,
'allow_add' => false,
'allow_remove' => false,
'target_element' => $multiFile,
));
$this->add($fileCollection);
 
$csrf = new Element\Csrf('csrf');
$this->add($csrf);
}
}