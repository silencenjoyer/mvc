<?php

declare(strict_types=1);

namespace app\core;

use JetBrains\PhpStorm\ArrayShape;

abstract class Model
{
    public const RULE_REQUIRED = 'rule_required';
    public const RULE_MAX = 'rule_max';
    public const RULE_MIN = 'rule_min';
    public const RULE_EMAIL = 'rule_email';
    public const RULE_MATCH = 'rule_match';

    public array $errors = [];

    abstract public function rules(): array;

    abstract public function labels(): array;

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $modelProperty = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$modelProperty) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_MIN && strlen($modelProperty) <= $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($modelProperty) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $modelProperty !== $this->{$rule['match']}) {
                    $rule['match'] = $this->labels()[$rule['match']];
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($modelProperty,FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, array $params = [])
    {
        $message = $this->getErrorMessage()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", (string) $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    #[ArrayShape(
        [
            self::RULE_REQUIRED => "string",
            self::RULE_MAX => "string",
            self::RULE_MIN => "string",
            self::RULE_EMAIL => "string",
            self::RULE_MATCH => "string"
        ]
    )]
    public function getErrorMessage(): array
    {
        return [
            self::RULE_REQUIRED => 'This is required field.',
            self::RULE_MAX => 'The max length of field is {max}.',
            self::RULE_MIN => 'The min length of field is {min}.',
            self::RULE_EMAIL => 'This is not correct email.',
            self::RULE_MATCH => 'This field is not match to {match}.',
        ];
    }

    public function hasError(string $attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    public function getError(string $attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }

    public function load(array $attributes): void
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }
}
