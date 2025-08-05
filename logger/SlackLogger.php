<?php
require_once 'LoggerInterface.php';

class SlackLogger implements LoggerInterface {
  public function log(string|array $message): string {
    return "Slack: " . json_encode($message) . PHP_EOL;
  }
}


