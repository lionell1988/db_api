<?php
class Message{

  public $code;
  public $txt;

  public function __construct($code, $txt){
    $this->code = $code;
    $this->txt = $txt;
  }

  public function toJSON(){
    /*
    $obj = new stdClass;
    $obj->code = $this->code;
    $obj->txt = $this->txt;
    return json_encode($obj);
    */
    return json_encode($this);
  }

}
