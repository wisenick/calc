<?php
namespace App\Calc;
use Closure;

class Decider
{
	private $max_weight;
	private $demand;
	private $tests = [];
	private $weight = 0;
	private $needRecalc = true;

	public function __construct(Demand $demand, int $maxWeight = 5)
	{
		$this->max_weight = $maxWeight;
		$this->demand = $demand;
	}

	public function addTest(Closure $closure):void
	{
		$this->needRecalc = true;
		$this->tests[] = new Test(
			$this->demand,
			$closure
		);
	}

	public function calc(): int
	{
		if ($this->needRecalc) {
			$this->weight = 0;

			foreach($this->tests as $key => $test) {
				$testResult = (int)$test->run();
				// echo "$key => $testResult".PHP_EOL;
				$this->weight += $testResult;
			}
			$this->needRecalc = false;
		}

		return $this->weight;
	}

	public function getWeight(): int
	{
		return $this->needRecalc ? $this->calc() : $this->weight;
	}

	public function decide(): bool
	{
		return $this->getWeight() < $this->max_weight;
	}
}
