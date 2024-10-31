<?php

namespace Core\Traits;

trait ValidatorTrait
{
    protected $errors = [];
    protected $patterns = [
        "cedula" => "/^([0-9]{7,9})$/",
        "rif" => "/^([vejpgVEJPG]{1})([0-9]{9})$/",
        "string"  => "/^([A-Za-zñÑáéíóúÁÉÍÓÚ\s-]{2,50})+$/",
        "phone" => "/0{0,2}([\+]?[\d]{1,3} ?)?([\(]([\d]{2,3})[)] ?)?[0-9][0-9 \-]{6,}( ?([xX]|([eE]xt[\.]?)) ?([\d]{1,5}))?/",
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
        'numeric' => '/^[0-9]+$/',
        'alphanumeric' => '/^[a-zA-Z0-9]+$/',
        'email' => "/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/", 
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
            }
            
            if (strpos($rule, 'regex:') === 0) {
                $patternKey = substr($rule, 6);
                $this->validateRegex($field, $data[$field] ?? null, $patternKey);
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
        if (!array_key_exists($patternKey, $this->patterns)) {
            $this->errors[$field][] = "Patrón '$patternKey' no definido.";
            return; 
        }
        
        $pattern = $this->patterns[$patternKey];
        if (!preg_match($pattern, $value)) {
            $this->errors[$field][] = "$field no tiene el formato correcto según el patrón '$patternKey'.";
        }
    }
}
