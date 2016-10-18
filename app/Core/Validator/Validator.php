<?php 
namespace App\Core\Validator;
use \DateTime;
class Validator
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
     * @var array
     */
    protected $errors;
    public function __construct($data = array(), $rules = array())
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->errors = array();
    }
    /**
     * Check if the validation passes
     * @return bool
     */
    public function passes()
    {
        $hasPassed = true;
        foreach ($this->data as $data => $value) 
        {
            if(isset($this->rules[$data]))
            {
                $rules = explode('|', $this->rules[$data]);
                foreach ($rules as $rule) 
                {
                    if($rule == 'required' && empty($value))
                    {
                        $this->errors[$data] = "Vous devez remplir le champs $data";
                        $hasPassed = false;
                    }
                    else if(substr($rule, 0, 3) == 'min')
                    {
                        $rule = explode(':', $rule);
                        if(strlen($value) < $rule[1])
                        {
                            $this->errors[$data] = "Le champs $data doit faire au moins {$rule[1]} caractères";
                            $hasPassed = false;
                        }
                    }
                    else if(substr($rule, 0, 3) == 'max')
                    {
                        $rule = explode(':', $rule);
                        if(strlen($value) > $rule[1])
                        {
                            $this->errors[$data] = "Le champs $data doit faire moins de {$rule[1]} caractères";
                            $hasPassed = false;
                        }
                    }
                    else if(substr($rule, 0, 5) == 'upper')
                    {
                        if(!preg_match('/[A-Z]/', $data)){
                            $this->errors[$data] = "Le champs $data doit contenir au moins une majuscule";
                            $hasPassed = false;
                        }
                    }
                    else if(substr($rule, 0, 7) == 'numeric')
                    {
                        if(!preg_match('/(?=.*\d)/', $data)){
                            $this->errors[$data] = "Le champs $data doit contenir au moins un chiffre";
                            $hasPassed = false;
                        }
                    }
                    else if(substr($rule, 0, 4) == 'size')
                    {
                        $rule = explode(':', $rule);
                        if(strlen($value) != $rule[1])
                        {
                            $this->errors[$data] = "Le champs $data doit faire exactement {$rule[1]} caractères";
                            $hasPassed = false;
                        }
                    }
                    else if($rule == 'confirmed')
                    {
                        if(!isset($this->data[$data.'_confirm']) or ($value != $this->data[$data.'_confirm']))
                        {
                            $this->errors[$data.'_confirm'] = "Vous devez correctement confirmer le champs $data";
                            $hasPassed = false;
                        }
                    }
                    else if($rule == 'mail')
                    {
                        if(!filter_var($value, FILTER_VALIDATE_EMAIL))
                        {
                            $this->errors[$data] = "Le champs $data doit contenir une adresse mail valide.";
                            $hasPassed = false;
                        }
                    }
                    else if($rule == 'url')
                    {
                        if(!filter_var($value, FILTER_VALIDATE_URL))
                        {
                            $this->errors[$data] = "Le champs $data doit contenir une URL valide.";
                            $hasPassed = false;
                        }
                    }
                    else if(substr($rule, 0, 6) == 'before')
                    {
                        $rule = explode(':', $rule);
                        $date1 = new DateTime($value);
                        $date2 = new DateTime($rule[1]);
                        $before = $date1->diff($date2)->invert;
                        if($before > 0)
                        {
                            $this->errors[$data] = "Le champs $data doit être avant le {$rule[1]}";
                            $hasPassed = false;
                        }
                    }
                    else if(substr($rule, 0, 5) == 'after')
                    {
                        $rule = explode(':', $rule);
                        $date1 = new DateTime($value);
                        $date2 = new DateTime($rule[1]);
                        $after = !($date1->diff($date2)->invert);
                        if($after)
                        {
                            $this->errors[$data] = "Le champs $data doit être après le {$rule[1]}";
                            $hasPassed = false;
                        }
                    }
                    else if(substr($rule, 0, 7) == 'between')
                    {
                        $rule = explode(':', $rule);
                        $dates = explode('..', $rule[1]);
                        $date1 = new DateTime($value);
                        $date2 = new DateTime($dates[0]);
                        $date3 = new DateTime($dates[1]);
                        $before = $date1->diff($date2)->invert;
                        $after = !($date1->diff($date3)->invert);
                        if($before || $after)
                        {
                            $this->errors[$data] = "Le champs $data doit être entre le {$dates[0]} et le {$dates[1]}";
                            $hasPassed = false;
                        }
                    }
                }
            }
        }
        return $hasPassed;
    }
    /**
     * Check if the validation fails
     * @return bool
     */
    public function fails()
    {
        return ! $this->passes();
    }
    /**
     * Return the validation errors
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
