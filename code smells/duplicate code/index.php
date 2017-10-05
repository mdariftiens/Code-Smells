<?php

class Person
{ 
	protected $birth_date;
	
	public function setBirthdate($date)
	{
		$this->birth_date=$date;
	}
	
	public function getBirthdate()
	{
		return $this->birth_date;
	}
	
} 

class Customer extends Person
{
	public function getAge()
	{
		return date('Y') - date('Y', strtotime($this->getBirthdate()));
	} 
}

class Vendor extends Person
{
	public function getAge()
	{
		return date('Y') - date('Y', strtotime($this->getBirthdate()));
	}
}

$c=new Customer;
$c->setBirthdate("2010-12-15");
echo $c->getAge();

$v=new Vendor;
$v->setBirthdate("2000-12-15");
echo $v->getAge();
?>