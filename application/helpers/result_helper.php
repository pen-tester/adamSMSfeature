<?php
	class MessageResult{
		public $status;
		public $errors;
		public $msg;
		public $code;
		public $result;
		public $addtional_info;
		public function __construct(){
			$this->status="ok";
			$this->errors=array();
			$this->msg="success";
			$this->code=1;
			$this->result=0;
			$this->addtional_info=array();
		}
	}
?>