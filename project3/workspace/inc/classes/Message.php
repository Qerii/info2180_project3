<?php
  class Message {
    private $_db;

    public function __construct($user = null) {
      $this->_db = DB::getInstance();
    }

    public function create($message, $fields = array()) {
      if(!$this->_db->insert("`cheapo`.`".$message."`", $fields)) {
        throw new Exception('There was a problem creating a message');
      }
    }


    public function get($table, $where = array()) {
      if(count($where)) {
        return $this->_db->get($table, $where);
      }
      else {
        return $this->_db->get($table);
      }
    }


  }
?>
