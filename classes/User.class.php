<?php
class User {
	public $name;
	public $surname;
	public $username;
	public $email;
	public $token;
	public $password;

	public static function create($values) {
		return new User($values);
	}

	public function __construct($v) {
		$this->name     = $this->safely_set($v, 'name');
		$this->surname      = $this->safely_set($v, 'surname');
		$this->username = $this->safely_set($v, 'username');
		$this->email     = $this->safely_set($v, 'email');
		$this->token = $this->safely_set($v, 'token');
		$this->password  = $this->safely_set($v, 'password');
	}

	protected function safely_set($a, $k, $def = null) {
		return isset($a[$k]) && $a[$k] != null?$a[$k]:$def;
	}

        public function toJSON(){
            return json_encode( (array)$this);
        }
}
