<?php
require_once 'LoggerInterface.php';

class FileLogger implements LoggerInterface {
  public function log(string|array $message): string {
    return "File: " . json_encode($message) . PHP_EOL;
  }
}


