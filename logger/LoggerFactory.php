
<?php
require_once 'LoggerInterface.php';
require_once 'SlackLogger.php';
require_once 'FileLogger.php';
require_once 'ConsoleLogger.php';


class LoggerFactory {
  public static function create(string $type): LoggerInterface {
    switch ($type) {
      case 'slack':
        return new SlackLogger();
      case 'file':
        return new FileLogger();
      case 'console':
        return new ConsoleLogger();
      default:
        throw new Exception("Invalid logger type");
    }
  }
}
