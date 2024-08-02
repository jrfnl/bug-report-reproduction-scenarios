<?php

namespace Jrf\PHPUnit\Scenario\Deprecation;

use PHPUnit\Runner\Extension\Extension as PHPUnitExtension;
use PHPUnit\TextUI\Configuration\Configuration;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\Event\Test\DeprecationTriggered;

class DeprecationExtension implements PHPUnitExtension
{
    private static $instance;
    protected array $actualDeprecations = [];
    private $testInstance;

    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $facade->registerSubscribers(
            new DeprecationSubscriber(),
            new VerifyDeprecationExpectationsSubscriber(),
            new ResetSubscriber()
         );
    }

    public static function instance(): self
    {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function deprecations()
    {
        return self::instance()->actualDeprecations;
    }

    public static function deprecation($message)
    {
        return self::instance()->triggered($message)
            ? self::instance()->actualDeprecations[$message]
            : null;
    }

    public static function triggered($message): bool
    {
        return isset(self::instance()->actualDeprecations[$message]);
    }

    public function trigger(DeprecationTriggered $event): void
    {
        $message = $event->message();
        $this->actualDeprecations[$message] = true;
    }

    public function setTestInstance($testInstance): void
    {
        $this->testInstance = $testInstance;
    }

    public function validate(): void
    {
        $this->testInstance->verifyDeprecationExpectations();
    }

    public function reset(): void
    {
        $this->actualDeprecations = [];
        if ($this->testInstance)
        {
            $this->testInstance->resetExpectedUserDeprecationMessages();
        }
    }
}
