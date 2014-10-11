<?php

namespace Libs;

class Validation
{
	protected $data;
	protected $rules;
	protected $errors;

	public function __construct($data = array(), $rules = array())
	{
		$this->data = $data;
		$this->rules = $rules;
		$this->errors = '';
	}

	public function passes()
	{
		foreach ($this->data as $data => $value) 
		{
			if(isset($this->rules[$data]))
			{
				$rules = explode('|', $this->rules[$data]);
				foreach ($rules as $rule) 
				{
					if($rule == 'required' && empty($value))
					{
						$this->errors = "Vous devez remplir le champs $data";
						return false;
					}
					else if(substr($rule, 0, 3) == 'min')
					{
						$rule = explode(':', $rule);
						if(strlen($value) < $rule[1])
						{
							$this->errors = "Le champs $data doit faire au moins {$rule[1]} caractères";
							return false;
						}
					}
					else if(substr($rule, 0, 3) == 'max')
					{
						$rule = explode(':', $rule);
						if(strlen($value) > $rule[1])
						{
							$this->errors = "Le champs $data doit faire moins de {$rule[1]} caractères";
							return false;
						}
					}
					else if(substr($rule, 0, 4) == 'size')
					{
						$rule = explode(':', $rule);
						if(strlen($value) != $rule[1])
						{
							$this->errors = "Le champs $data doit faire exactement {$rule[1]} caractères";
							return false;
						}
					}
					else if($rule == 'confirmed')
					{
						if(!isset($this->data[$data.'_confirm']) or ($value != $this->data[$data.'_confirm']))
						{
							$this->errors = "Vous devez correctement confirmer le champs $data";
							return false;
						}
					}

					/**
					 * Email, Phone number, numeric, alpha, confirmed (for password)
					 */
				}
			}
		}
		return true;
	}

	public function fails()
	{
		return !$this->passes();
	}

	public function getErrors()
	{
		return $this->errors;
	}
}