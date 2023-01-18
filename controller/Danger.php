<?php
    class Danger {

        public function forbidden() {
            header('HTTP/1.0 403 Forbidden');
            header("Status: 403 Forbidden");
            include 'view/error/403.php';
        }

        public function notFound() {
            header("HTTP/1.0 404 Not Found");
            header("Status: 404 Not Found");
            include 'view/error/404.php';
        }

        public function FatalError() {
            header("HTTP/1.0 500 Fatal Error");
            header("Status: 500 Fatal Error");
            include 'view/error/500.php';
        }
    }