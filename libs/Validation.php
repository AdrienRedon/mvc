<?php

namespace Libs;

class Validation
{
    /**
     * Data to validate
     * @var array
     */
    protected $data;

    /**
     * Rules to be passed
     * @var array
     */
    protected $rules;

    /**
     * Validation first error
     * @var string
     */
    protected $errors;

    public function __construct($data = array(), $rules = array())
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->errors = '';
    }

    /**
     * Check if the validation passes
     * @return bool
     */
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
                    else if($rule == 'email')
                    {
                        if(!filter_var($value, FILTER_VALIDATE_EMAIL))
                        {
                            $this->errors = "Le champs $data doit contenir une adresse mail valide.";
                            return false;
                        }
                    }
                    else if(substr($rule, 0, 6) == 'before')
                    {
                        $rule = explode(':', $rule);
                        $date1 = new \DateTime($value);
                        $date2 = new \DateTime($$rule[1]);
                        $date1->diff($date2);
                    }
                }
            }
        }
        return true;
    }

    /**
     * Check if the validation fails
     * @return bool
     */
    public function fails()
    {
        return !$this->passes();
    }

    /**
     * Return the validation errors
     * @return string
     */
    public function getErrors()
    {
        return $this->errors;
    }

}
