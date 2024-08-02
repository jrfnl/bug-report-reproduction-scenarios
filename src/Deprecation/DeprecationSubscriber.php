<?php

namespace Jrf\PHPUnit\Scenario\Deprecation;

use PHPUnit\Event\Test\DeprecationTriggeredSubscriber;
use PHPUnit\Event\Test\DeprecationTriggered;

class DeprecationSubscriber implements DeprecationTriggeredSubscriber
{
    public function notify(DeprecationTriggered $event): void
    {
        DeprecationExtension::instance()->trigger($event);
    }
}
