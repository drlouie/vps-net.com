<?php 
//-----------------------------------------------------------
//     NumberToWord 
//-----------------------------------------------------------
class NumberToWord
{
	private $numero=array('0'=>'zero','1'=>'one','2'=>'two','3'=>"three",'4'=>"four",'5'=>"five",'6'=>'six','7'=>'seven',
	'8'=>'eight','9'=>'nine','10'=>'ten','11'=>'eleven',"12"=>'twelve','13'=>'thirteen','14'=>'fourteen',
	'15'=>'fifteen','16'=>'sixteen','17'=>'seventeen','18'=>'eighteen','19'=>'nineteen','-'=>'minus');
	
	private $diezes=array('2'=>'twenty','3'=>'thirty','4'=>'forty','5'=>'fifty','6'=>'sixty',
	'7'=>'seventy','8'=>'eighty','9'=>'ninty');
	
	private $grandes=array('',"thousand,","million,","billion,","trillion,","quadrillion,","quintillion,","sextillion,",
	"septillion,","octillion,","nonillion,","decillion,","unidecillion,","duodecillion,","tredecillion,","quattuordecillion,");

	private $palabra; //la palabra final
	private $error; //saca error

	//funcciones
	private function dosnumeros($num)
	{
		//ensena del 1 hasta el 99
		if($num<20)
			return $this->numero[$num];
		else
			return $this->diezes[substr($num,0,1)].'-'.$this->numero[substr($num,1,1)];
	}
	
	//ensena numeros de tres
	private function tresnumeros($num)
	{
		return $this->numero[substr($num,0,1)].' hundred and '.$this->dosnumeros(substr($num,1,2));
	}
	
	private function encuentralos($num)
	{
		if(strlen($num)<=2)
			return $this->dosnumeros($num);
		else
			return $this->tresnumeros($num);
	}
	
	public function haslos($num)
	{
		//mas que 48 numeros
		if(strlen($num)>48) 
		{
			$this->error="Number out of bounds";
			return $this->error;
		}
		
		//es primero?
		if(substr($num,0,1)=="-")
		{
			$this->palabra.='minus ';
			$num=substr($num,1,strlen($num)-1);
		}
		
		if(strlen($num)<=3)
		{
			$this->palabra.=$this->encuentralos($num);
		}
		else
		{
			$k=strrev($num);
			for($i=0;$i<strlen($k);$i=$i+3){$arro[]=strrev(substr($k,$i,3));}
			//voltiarlos
			$arro=array_reverse($arro);
			$mool=ceil(strlen($num)/3);
			if((strlen(num)%3)==0){$mool--;}
			$this->palabra.=$this->encuentralos($arro[0]).' '.$this->grandes[$mool];
			$mool--;
			//deja el primero y prepara los demas
			$arrlen=count($arro);
			for($i=1;$i<$arrlen;$i++)
			{
				$this->palabra.=' '.$this->encuentralos($arro[$i]);
				if($mool!=0)
				{
					$this->palabra=' '.$this->palabra.' '.$this->grandes[$mool];
				}
				$mool--;
			}
		}
		return ucfirst(trim($this->palabra));
	}
}
?>
