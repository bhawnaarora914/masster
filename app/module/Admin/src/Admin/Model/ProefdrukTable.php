<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;

class ProefdrukTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($params=array())
    {
		$resultSet = $this->tableGateway->select($params);
        return $resultSet;
    }

	public function fetchSearchQuery($search_query)
    {
		$where = new Where();
		$where->like('proof_number', trim($search_query).'%');
		$where->OR->like('proof_customer_name', '%'.trim($search_query).'%');
                $where->OR->like('proof_customer_email', '%'.trim($search_query).'%');


        $resultSet = $this->tableGateway->select($where);
		return $resultSet;
    }

    public function getProefdruk($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('proof_id' => $id));
        $row = $rowset->current();
   
        return $row;
    }
	
	public function updateProefdruk($data,$proof_id)
	{
		$this->tableGateway->update($data, array('proof_id' => $proof_id));
	}
	

    public function saveProefdruk(Proefdruk $proefdruk,$payment_methods)
    {
        $data = array(
            'proof_id' =>  $proefdruk->proof_id,
            'proof_number' => $proefdruk->proof_number,
            'proof_file'  => $proefdruk->proof_file,
            'proof_customer_name' =>  $proefdruk->proof_customer_name,
            'proof_autoremind'=>$proefdruk->proof_autoremind,
            'proof_add_option'=>$proefdruk->proof_add_option,
            'proof_size_customer'=>$proefdruk->proof_size_customer,
            'proof_amount' => $proefdruk->proof_amount,
            'proof_paymethod' =>  $payment_methods,
            'proof_rushorder'=>$proefdruk->proof_rushorder,
            'proof_date' => $proefdruk->proof_date,
            'proof_time' =>  $proefdruk->proof_time,
            'proof_comment'=>$proefdruk->proof_comment,
            'proof_rushdate'=>$proefdruk->proof_rushdate,
            'proof_customer_email'=>$proefdruk->proof_customer_email ,
            'proof_pay_comment'=>$proefdruk->proof_pay_comment,
            'proof_rush_comment'=>$proefdruk->proof_rush_comment,
            'proof_adress_comment'=>$proefdruk->proof_adress_comment,
            'proof_global_option_comment'=>$proefdruk->proof_global_option_comment,
            'proof_size_customer_comment'=>$proefdruk->proof_size_customer_comment
        );
	
		
        $id = (int)$proefdruk->proof_id;
	
        if ($id == 0) {
            $this->tableGateway->insert($data);
			return $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getProefdruk($id)) {
            	
            	if($data['proof_rushorder']==1)  {
            		$data['proof_autoremind'] = 0;
            	}
               $this->tableGateway->update($data, array('proof_id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteProefDruk($id)
    {
        $this->tableGateway->delete(array('proof_id' => $id));
    }
}