<?php

interface LoggerInterface {
  public function log(string|array $message): string;
}
