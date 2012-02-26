<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class User extends Mapper
{
    protected $_table = 'user';
    protected $_model = '\Onside\Model\User';

    public function doOnsideLogin($email, $password)
    {
	return $this->selectItem(array('email' => array('=', $email, 'AND'), 'password' => "PASSWORD('$password')"), array(), null);
    }

    public function doFacebookLogin($uid, $email)
    {
	$return = $this->selectItem(array('facebook' => $uid), array(), null);
	if (count($return) == 0) {
	    $return = $this->addItem(array('facebook' => $uid, 'email' => $email, 'language' => 'en_gb', 'enabled' => 0, 'admin' => 0, 'status' => 0));
	    // TODO: insert will fail if email address already exists in the system
	}

	return $return;
    }

    public function doTwitterLogin($uid, $email)
    {
	$return = $this->selectItem(array('twitter' => $uid), array(), null);
	if (count($return) == 0) {
	    $return = $this->addItem(array('twitter' => $uid, 'email' => $email, 'language' => 'en_gb', 'enabled' => 0, 'admin' => 0, 'status' => 0));
	}

	return $return;
    }

    public function doGoogleLogin($uid, $email)
    {
	$return = $this->selectItem(array('google' => $uid), array(), null);
	if (count($return) == 0) {
	    $return = $this->addItem(array('google' => $uid, 'email' => $email, 'language' => 'en_gb', 'enabled' => 0, 'admin' => 0, 'status' => 0));
	}

	return $return;
    }

    public function updateItem($id, array $data)
    {
        $users = $this->_selectItem(array('id' => $id), array(), null, null);
        $existing = $users[0];

        if ($existing && !$existing->enabled && $data['enabled'] && !$existing->password) {
            $passwd = $this->getRandomPassword();
            $data['password'] = $passwd;

            // create user
            $users  = $this->_updateItem($id, $data);
            $user = $users[0];

            // send email
            $mapper = new Email($this->_db);
            $template = $mapper->selectItem(array('name' => 'user_enabled'));
            $template[0]->to = $user->email;
            $email = new \Onside\Email($template[0]);
            $user->password = $passwd; //So that the user sees an unencrypted password
            $email->sendEmail((array) $user);
            $user->password = null;
            return $users;
        }
	else {
            return $this->_updateItem($id, $data);
        }

    }

    public function addItem(array $data)
    {
        if (!isset($data['name'])) {
            $emailParts = explode('@', $data['email']);
            $data['name'] = ucfirst($emailParts[0]);
        }
        $users = $this->_addItem($data);
        $mapper = new Email($this->_db);
        $templates = $mapper->selectItem(array('name' => 'registration'));
        $templates[0]->to = $users[0]->email;
        $email = new \Onside\Email($templates[0]);
        $email->sendEmail((array) $users[0]);
        return $users;
    }

    //TODO: This needs to be done by not selecting the password from the DB in the first place
    //Think we still need to be binding to real objects to ensure that there's an empty field though
    public function selectItem($where = array(), $sort = array(), $limit = null, $join = array())
    {
        return $this->blankPasswords($this->_selectItem($where, $sort, $limit, $join));
    }

    public function getItem($id)
    {
        return $this->blankPasswords($this->_selectItem(array('id' => $id), array(), null, null));
    }

    private function blankPasswords(array $users)
    {
        foreach ($users as $user) {
            $user->password = null;
        }
        return $users;
    }

    private function getRandomPassword()
    {
	return uniqid();
    }
}
