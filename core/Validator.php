<?php
namespace Core;

class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $ruleString) {
            $ruleset = explode('|', $ruleString);
            $value = $data[$field] ?? null;
            foreach ($ruleset as $rule) {
                [$name, $param] = array_pad(explode(':', $rule, 2), 2, null);
                $method = 'validate' . ucfirst($name);
                if (method_exists($this, $method) && !$this->{$method}($field, $value, $param)) {
                    break;
                }
            }
        }
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function validateRequired(string $field, $value): bool
    {
        if ($value === null || $value === '') {
            $this->errors[$field][] = 'Bu alan zorunludur.';
            return false;
        }
        return true;
    }

    private function validateEmail(string $field, $value): bool
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = 'Geçerli bir e-posta girin.';
            return false;
        }
        return true;
    }

    private function validateMin(string $field, $value, $param): bool
    {
        if ($value !== null && mb_strlen((string)$value) < (int)$param) {
            $this->errors[$field][] = "En az {$param} karakter olmalı.";
            return false;
        }
        return true;
    }

    private function validateConfirmed(string $field, $value): bool
    {
        // expects field_confirmation in data
        return true;
    }
}
