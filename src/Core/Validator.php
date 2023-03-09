<?php

namespace App\Core;

class Validator 
{

    public $patterns = array(
        'email' => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]{2,}',
        'text' => '.+',
        'title' => '[a-zA-Z ]*',
        'slug' => '[a-z0-9-]+',
    );

    public $errors = array();

    public $value;

    public $name;

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function value($value) 
    {
        $this->value = $value;
        return $this;
    }

    public function pattern($pattern) 
    {
        $regex = '/('.$this->patterns[$pattern].')/';
        if ($this->value != '' && !preg_match($regex, $this->value) )
        {
            $this->errors[] = 'Format for '.$this->name.' is not valid.';
        }

        return $this;
    }

    public function required()
    {
        if(($this->value == '' || $this->value == null))
        {
            $this->errors[] = 'Value '. $this->name . ' is required.';
        }
    }

    public function isSuccess()
    {
        if (empty($this->errors)) {
            return true;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}