<?php
namespace SuperPay;
class Init
{
	protected $baseParam  = null;
	public function __construct($param)
	{
		$this->baseParam = $param;
	}
    public function query($data,$event='commit')
    {
        $className = 'SuperPay\\'.$data['class_type_name'].'\\' . $data['class_name'];
        unset($data['class_type_name'],$data['class_name']);
        $obj       = new $className($this->baseParam);
        return $obj->$event($data);
    }
}