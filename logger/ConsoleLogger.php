<?php
require_once 'LoggerInterface.php';

class ConsoleLogger implements LoggerInterface {
  public function log(string|array $message): string {
    return "Console: " . json_encode($message) . PHP_EOL;
  }
}


