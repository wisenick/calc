<?php
namespace App\Calc;
use DateTime;
use Exception;

class Demand
{
	private $name;
	private $last_name;
	private $second_name;
	private $age;
	private $gender;
	private $birthday;
	private $infants;
	private $engagement;
	private $salary;
	private $employment;
	private $has_property;
	private $has_credits;
	private $has_debt;
	private $current_debt;

	private $errors = [];

	private $fields = [
		'name',
		'last_name',
		'second_name',
		'gender',
		'birthday',
		'infants',
		'engagement',
		'salary',
		'employment',
		'has_property',
		'has_credits',
		'has_debt',
		'current_debt'
	];

	private $required_fields = [
		'name',
		'last_name',
		'gender',
		'birthday',
		'infants',
		'engagement',
		'salary',
		'employment',
		'has_property',
		'has_credits',
	];

	private $related_fields = [
		'has_credits' => [
			'has_debt',
			'current_debt'
		],
	];

	public function __construct(array $data)
	{
		foreach ($this->fields as $fieldName) {
			if ($this->isFieldRequired($fieldName) && !isset($data[$fieldName])) {
				$this->errors[] = $fieldName;
				continue;
			}

			if ($this->isFieldHasRelations($fieldName)) {
				foreach ($this->related_fields[$fieldName] as $relatedField) {
					if (!isset($data[$fieldName])) {
						$this->errors[] = $fieldName;
					}
				}
			}

			$this->{$fieldName} = $data[$fieldName];
		}

		$this->age = static::countAge(new DateTime($this->birthday));
	}

	private function isFieldRequired($fieldName): bool
	{
		$hash = array_flip($this->required_fields);
		return isset($hash[$fieldName]);
	}

	private function isFieldHasRelations($fieldName): bool
	{
		return isset($this->related_fields[$fieldName]);
	}

	public function hasErrors(): bool
	{
		return !empty($this->errors);
	}

	public function getErrors(): array
	{
		return $this->errors;
	}

	protected static function countAge(DateTime $date): int
	{
		$now = new DateTime();

		return ($now->diff($date))->y;
	}

	public function __call($method, $args)
	{
		$action = substr($method, 0, 3);

		if (method_exists($this, $method)) {
			return call_user_func_array([$this, $method], $args);
		}

		switch ($action) {
			case 'get':
				$property = strtolower(
					substr(
						strtolower(
							preg_replace('/(?<!^)[A-Z]/', '_$0', $method)
						), 
						4
					)
				);

				if (property_exists($this, $property)) {
					return $this->{$property};
				} else {
					throw new Exception("Undefined Property {$property}");
				}
				break;

			default :
				return false;
		}
	}
}
