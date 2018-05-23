<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Application\Model;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class CustomerdeliveryTable
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

    public function getCustomerDelivery($id,$by_proofid=false)
    {
        	$id  = (int) $id;
			if($by_proofid==false) {
				$rowset = $this->tableGateway->select(array('cd_id' => $id));
			} else {
				$rowset = $this->tableGateway->select(array('proof_id' => $id));
			}
			
	        $row = $rowset->current();
	        return $row;
        
    }
	
    public function saveCustomerDelivery($data)
    {
        $this->tableGateway->insert($data);
		return $this->tableGateway->getLastInsertValue();
        
       
    }
	
	

    public function deleteCustomerdelivery($id)
    {
        $this->tableGateway->delete(array('cd_id' => $id));
    }
}