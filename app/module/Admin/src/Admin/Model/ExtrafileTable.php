<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Admin\Model;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;


class ExtrafileTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
    	
    		 $resultSet = $this->tableGateway->select();
			 return $resultSet;
    	
    }
	
	public function saveFile($data)
    {
        

    $this->tableGateway->insert($data);
	return $this->tableGateway->getLastInsertValue();
       
    }

    public function getExtrafile($proof_id)
    {
    	
        $rowset = $this->tableGateway->select(array('proof_id' => $proof_id));
        return $rowset;
    }
	
	

    public function deleteFile($id)
    {
        $this->tableGateway->delete(array('file_id' => $id));
    }
}