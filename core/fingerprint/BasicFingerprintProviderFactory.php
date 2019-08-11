<?php
    namespace App\Core\Fingerprint;

    use App\Core\Fingerprint\BasicFingerprintProvider;

    class BasicFingerprintProviderFactory {
        public function getInstance(string $arraysource): BasicFingerprintProvider {
            switch ($arraysource) {
                case 'SERVER' :
                    return new BasicFingerprintProvider($_SERVER);
            }

            return new BasicFingerprintProvider($_SERVER);
        }
    }