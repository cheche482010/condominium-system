<?php

namespace App\Controllers\Validation;

class Validator
{
    protected $errors = [];
    protected $patterns = [
        'numeric' => '/^[0-9]+$/',
        'alphanumeric' => '/^[a-zA-Z0-9]+$/',
        'email' => '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', 
    ];

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);
            foreach ($rulesArray as $rule) {
                
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $param] = explode(':', $rule);
                    $methodName = 'validate' . ucfirst($ruleName);
                    if (method_exists($this, $methodName)) {
                        $this->$methodName($field, $data[$field] ?? null, $param);
                    }
                } else {
                    $methodName = 'validate' . ucfirst($rule);
                    if (method_exists($this, $methodName)) {
                        $this->$methodName($field, $data[$field] ?? null);
                    }
                }

        
                if (strpos($rule, 'regex:') === 0) {
                    $patternKey = substr($rule, 6);
                    $this->validateRegex($field, $data[$field] ?? null, $patternKey);
                }

            }
        }
        return $this->errors;
    }

    public function validateRequired($field, $value)
    {
        if (empty($value)) {
            $this->errors[$field][] = "$field es obligatorio.";
        }
    }

    public function validateMin($field, $value, $min)
    {
        if (strlen($value) < $min) {
            $this->errors[$field][] = "$field debe tener al menos $min caracteres.";
        }
    }

    public function validateMax($field, $value, $max)
    {
        if (strlen($value) > $max) {
            $this->errors[$field][] = "$field no debe tener más de $max caracteres.";
        }
    }

    public function validateRegex($field, $value, $patternKey)
    {
        if (array_key_exists($patternKey, $this->patterns)) {
            $pattern = $this->patterns[$patternKey];
            if (!preg_match($pattern, $value)) {
                $this->errors[$field][] = "$field no tiene el formato correcto según el patrón '$patternKey'.";
            }
        } else {
            $this->errors[$field][] = "Patrón '$patternKey' no definido.";
        }
    }
}
