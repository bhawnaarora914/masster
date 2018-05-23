<?php // http://samsonasik.wordpress.com/2012/08/14/zend-framework-2-zenddbsql-join-tables/
//http://bigemployee.com/zend-framework-2-simple-web-application-crud-using-ajax-tutorial/
namespace Admin\Model;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;


class UserTable
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
	
	public function saveUser(User $user)
    {
        $data = array(
            'username' =>  $user->username,
            'password' => md5($user->password)
        );
	
		
        $id = (int)$user->user_id;
        if ($id == 0) {
        	
            $this->tableGateway->insert($data);
			return $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getUser('',$id)) {
            
                $this->tableGateway->update($data, array('user_id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function getUser($byidentity='',$id)
    {
    	if($byidentity!='') {
    		
        	$rowset = $this->tableGateway->select(array('username' => $byidentity));
    	} else {
    		$id  = (int) $id;
        	$rowset = $this->tableGateway->select(array('user_id' => $id));
    	}
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
	
	

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('user_id' => $id));
    }
}