<?php

namespace Jrf\PHPUnit\Scenario\Deprecation;

use PHPUnit\Event\Test\AfterTestMethodFinishedSubscriber;
use PHPUnit\Event\Test\AfterTestMethodFinished;

class VerifyDeprecationExpectationsSubscriber implements AfterTestMethodFinishedSubscriber
{
    public function notify(AfterTestMethodFinished $event): void
    {
        DeprecationExtension::instance()->validate($event);
    }
}
