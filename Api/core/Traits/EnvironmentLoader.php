<?php

namespace Core\Traits;

trait EnvironmentLoader
{
    protected function loadEnvironmentVariables()
    {
        if (!isset($_ENV['APP_ENV'])) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }
    }
}