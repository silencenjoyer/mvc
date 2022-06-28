<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    public string $name = '';
    public string $email = '';
    public string $pass = '';
    public string $passConfirm = '';

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'pass' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3]],
            'passConfirm' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MATCH, 'match' => 'pass']],
        ];
    }

    public function labels(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'pass' => 'Password',
            'passConfirm' => 'Confirm Password',
        ];
    }
}
