<?php

namespace Jrf\PHPUnit\Scenario\Deprecation;

use PHPUnit\Event\Code\ComparisonFailureBuilder;
use PHPUnit\Event\Code\ThrowableBuilder;
use PHPUnit\Event\Facade as EventFacade;
use PHPUnit\Framework\ExpectationFailedException;

trait ExpectUserDeprecation
{
    protected $expectedUserDeprecationMessage = [];
    protected $expectedUserDeprecationMessageRegularExpression = [];

    final protected function expectUserDeprecationMessage($expectedUserDeprecationMessage): void
    {
        $this->setUpExpectUserDeprecation();
        $this->expectedUserDeprecationMessage[$expectedUserDeprecationMessage] = false;
    }

    final protected function expectUserDeprecationMessageMatches($expectedUserDeprecationMessageRegularExpression): void
    {
        $this->setUpExpectUserDeprecation();
        $this->expectedUserDeprecationMessageRegularExpression[] = $expectedUserDeprecationMessageRegularExpression;
    }

    private function setUpExpectUserDeprecation(): void
    {
        DeprecationExtension::instance()->setTestInstance($this);
        $this->addToAssertionCount(1);
    }

    final public function verifyDeprecationExpectations(): void
    {
        foreach (array_keys($this->expectedUserDeprecationMessage) as $deprecationExpectation)
        {
            if (DeprecationExtension::triggered($deprecationExpectation))
            {
                static::assertThat(true, static::isTrue());
            }
            else
            {
                $message = sprintf(
                        'Expected deprecation with message "%s" was not triggered',
                        $deprecationExpectation,
                );
                $e = new ExpectationFailedException($message);
                EventFacade::emitter()->testFailed(
                    $this->valueObjectForEvents(),
                    ThrowableBuilder::from($e),
                    ComparisonFailureBuilder::from($e),
                );    
            }
        }
    }

    public function resetExpectedUserDeprecationMessages(): void
    {
        $this->expectedUserDeprecationMessage = [];
        $this->expectedUserDeprecationMessageRegularExpression = [];
    }
}
