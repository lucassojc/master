<?php
    namespace App\Validators;

    use \App\Core\Validator;

    class SessionValidator implements Validator {
        public function isValid(string $value): bool {
            return \boolval(\preg_match('[A-Za-z0-9]{32}', $value));
        }
    }