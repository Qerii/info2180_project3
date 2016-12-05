<?php
class User {
  private $_db, $_data, $_sessionName, $_isLoggedIn;

  public function __construct($user = null) {
    $this->_db = DB::getInstance();
    $this->_sessionName = Config::get('session/session_name');

      if(Session::exists($this->_sessionName)) {
        $user = Session::get($this->_sessionName);

        if($this->find($user)) {
          $this->_isLoggedIn = true;
        }
        else {
          // process Logout
          $this->logout();
          $thsi->_isLoggedIn = false;
        }

    } else {
      $this->find($user);
    }
  }

  public function create($fields = array()) {
    if(!$this->_db->insert("`cheapo`.`User`", $fields)) {
      throw new Exception('There was a problem creating an account');
    }
  }

  public function find($user = null) {
    if($user) {
      $field = (is_numeric($user)) ? 'id' : 'username';
      $_data = $this->_db->get('User', array($field, '=', $user));

      if($_data->count()) {
        $this->_data = $_data->first();
        return true;
      }
    }
    return false;
  }

  public function login($username = null, $password = null ) {
    $user = $this->find($username);
    var_dump($user);
    if($user) {
      if($this->data()['password'] === md5($password))  {
        Session::put($this->_sessionName, $this->data()['id']);

        return true;
      }
    }

    return false;
  }

  public function logout() {
    Session::delete($this->_sessionName);
  }

  public function data() {
    return $this->_data;
  }

  public function isLoggedIn() {
    return $this->_isLoggedIn;
  }

}
?>
