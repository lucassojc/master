<?php
    namespace App\Core\session;

    interface SessionStorage {
        public function save(string $sessionId, string $sessionData);
        public function load(string $sessionId): string;
        public function delete(string $sessionId);
        public function cleanUp(int $sessionAge);
    }