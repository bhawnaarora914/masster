<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Application\Model;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class UseruploadedfileTable
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

    public function getUploadedfiles($id)
    {
        	$id  = (int) $id;
			$rowset = $this->tableGateway->select(array('proof_id' => $id));
			return $rowset;
        
    }
	
    public function saveUploadedfile($data)
    {
        $this->tableGateway->insert($data);
		return $this->tableGateway->getLastInsertValue();
        
       
    }
	

    public function deleteUploadedFile($id)
    {
        $this->tableGateway->delete(array('u_fid' => $id));
    }
}