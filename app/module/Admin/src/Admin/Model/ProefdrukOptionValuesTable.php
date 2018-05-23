<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Admin\Model;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;


class ProefdrukOptionValuesTable
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

    public function getOptionValueName($id,$byparent=false)
    {
        $id  = (int) $id;
		if($byparent==false) {
			$rowset = $this->tableGateway->select(array('o_id' => $id));
	        $row = $rowset->current();
	        return $row;
		} else {
			return $this->tableGateway->select(array('proof_opt_id' => $id));

		}
       
    }
	
	
	public function setOptionValue($o_id,$value)
	{
		 $this->tableGateway->update(array('o_value'=>$value), array('o_id' => $o_id));
	}
	

    public function saveOptionValueName($data)
    {
        $this->tableGateway->insert($data);
		return $this->tableGateway->getLastInsertValue();
     
    }
	
	public function updateCustomValue($o_id)
	{
		 $this->tableGateway->update(array('custom_checked'=>1), array('o_id' => $o_id));
	}
	
	
	

    public function deleteProefdrukOptionValue($id,$byparent=false,$bycustom=false)
    {
    	if($byparent==false) {
    		$this->tableGateway->delete(array('o_id' => $id));
    	} else  {
    		if($bycustom==false) {
    			$this->tableGateway->delete(array('proof_opt_id' => $id));
    		} else {
    			$this->tableGateway->delete(array('proof_opt_id' => $id,'custom'=>0));
				$this->tableGateway->update(array('custom_checked'=>0), array('proof_opt_id' => $id));
    		}
    		
    	}
        
    }
}