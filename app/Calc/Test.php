<?php
namespace App\Calc;
use Closure;

class Test
{
	private $demand;
	private $function;

	public function __construct(Demand $demand, Closure $closure)
	{
		$this->demand = $demand;
		$this->function = $closure;
	}

	public function run(): int
	{
		return (int)call_user_func($this->function, $this->demand);
	}
}
