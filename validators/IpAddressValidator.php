<?php
    namespace App\Validators;

    use \App\Core\Validator;

    class IpAddressValidator implements Validator {
        public function isValid(string $value): bool {
            if (filter_var($value, FILTER_VALIDATE_IP)) {  // || \boolval(\preg_match('[:]{2}[0-9]+', $value))
                return true;
            }
            return false;
        }
    }