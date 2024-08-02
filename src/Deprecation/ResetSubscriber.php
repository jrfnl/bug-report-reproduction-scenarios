<?php

namespace Jrf\PHPUnit\Scenario\Deprecation;

use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;

class ResetSubscriber implements PreparedSubscriber
{
    public function notify(Prepared $event): void
    {
        DeprecationExtension::instance()->reset();
    }
}
