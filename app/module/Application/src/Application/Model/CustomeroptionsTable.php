<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Application\Model;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class CustomeroptionsTable
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

    public function getCustomerOption($id,$byproof_id=false)
    {
        	$id  = (int) $id;
			if($byproof_id==false){
				$rowset = $this->tableGateway->select(array('co_id' => $id));
			} else {
				$rowset = $this->tableGateway->select(array('proof_id' => $id));
			}
	        $row = $rowset->current();
	        return $row;
        
    }
	
    public function saveCustomerOption($data)
    {
        $this->tableGateway->insert($data);
		return $this->tableGateway->getLastInsertValue();
        
       
    }
	
	

    public function deleteCustomerOption($id)
    {
        $this->tableGateway->delete(array('co_id' => $id));
    }
}