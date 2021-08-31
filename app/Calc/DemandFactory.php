<?php
namespace App\Calc;

class DemandFactory
{
	public static function makeDemand(array $data): Demand
	{
		return new Demand($data);
	}
}
