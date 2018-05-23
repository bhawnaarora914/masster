<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Admin\Model;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Sql;

class ProefdrukOptionNameTable
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

    public function getOptionName($id,$byproof=false)
    {
        $id  = (int) $id;
		if($byproof==false) {
			$rowset = $this->tableGateway->select(array('proof_opt_id' => $id));
	        $row = $rowset->current();
	        return $row;
		} else {
			$resultSet = $this->tableGateway->select(array('proof_id' => $id));
			return $resultSet;
		}
        
    }
	
	
	
	public function  getOptionsWithValues($proof_opt_id,$custom=false,$proof_id=0)
	{
		$sql = new Sql($this->tableGateway->getAdapter());
	    $select =  $this->tableGateway->getSql()->select();
		$Where = new Where();
		if($proof_id==0) {
			$Where->equalTo('admin_proefdruk_option_name.proof_opt_id', $proof_opt_id);
		} else {
			$Where->equalTo('admin_proefdruk_option_name.proof_id', $proof_id);
		}
		
		if($custom==true) {
			$Where->equalTo('a.custom', 1);
		}
		
	   	$select->join(array('a' => 'admin_proefdruk_option_values'), 'admin_proefdruk_option_name.proof_opt_id = a.proof_opt_id', array('*'),'left');
		$select->where($Where);
		//echo $select->getSqlString(); // see the sql query
	    $resultSet = $this->tableGateway->selectWith($select);
		$resultSet->buffer(); //http://stackoverflow.com/questions/13719320/php-array-loop-error
	    return $resultSet;
		
	}
	

    public function saveOptionName(ProefdrukOptionName $proefdrukoptionname)
    {
    	
        $data = array(
            'proof_opt_id' =>  $proefdrukoptionname->proof_opt_id,
            'proof_opt_name' => $proefdrukoptionname->proof_opt_name,
            'proof_opt_maxvalue'=>$proefdrukoptionname->proof_opt_maxvalue,
            'proof_opt_description'  => $proefdrukoptionname->proof_opt_description,
            'proof_id'=>$proefdrukoptionname->proof_id
          
        );
		
        $id = (int)$proefdrukoptionname->proof_opt_id;
        if ($id == 0) {
        	
            $this->tableGateway->insert($data);
			return $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getOptionName($id)) {
                $this->tableGateway->update($data, array('proof_opt_id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
	
	
	public function updateOptionNameAjax($data,$id)
	{
		 $this->tableGateway->update($data, array('proof_opt_id' => $id));
	}

    public function deleteProefdrukOptionName($id)
    {
        $this->tableGateway->delete(array('proof_opt_id' => $id));
    }
}