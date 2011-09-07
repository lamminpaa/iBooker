<?php
class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract {
    protected $_name = 'users';
    
    public function authenticate($values)
    {
        // Get our authentication adapter and check credentials
        $adapter = $this->getAuthAdapter();
        $adapter->setIdentity($values['email']);
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);

        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }

        return false;
    }
    public function register($userData){
        $row = $this->fetchRow(
               $this->select()
                    ->where('email = ?', $userData['email']));
        if($row){
            return false;
        }
        else {
            $salt = sha1(uniqid(rand(), true));
            $password = sha1($userData['password'].$salt);

            $data = array(
            'email'         => $userData['email'],
            'password'      => $password,
            'password_salt' => $salt
            );
            $this->insert($data);
            return true;
        }
        
    }

    private function getAuthAdapter()
    {

        $authAdapter = new Zend_Auth_Adapter_DbTable();

        $authAdapter->setTableName('users')
                ->setIdentityColumn('email')
                ->setCredentialColumn('password')
                ->setCredentialTreatment('SHA1(CONCAT(?,password_salt))');

        return $authAdapter;
    }
    private function createSalt(){

        for ($i = 0; $i < 50; $i++) {
        $dynamicSalt .= chr(rand(33, 126));
        }
        return $dynamicSalt;
    }
}