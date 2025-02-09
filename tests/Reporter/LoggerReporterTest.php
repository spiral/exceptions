<?php

declare(strict_types=1);

namespace Spiral\Tests\Exceptions\Reporter;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Spiral\Exceptions\ExceptionHandler;
use Spiral\Exceptions\Reporter\LoggerReporter;

final class LoggerReporterTest extends TestCase
{
    public function testReport(): void
    {
        $exception = new \Exception();

        $logger = m::mock(LoggerInterface::class);
        $logger->shouldReceive('error')->withArgs([\sprintf(
            '%s: %s in %s at line %s',
            $exception::class,
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
        )])->once();

        $handler = new class extends ExceptionHandler {
            protected function bootBasicHandlers(): void {}
        };

        $handler->addReporter(new LoggerReporter($logger));

        $handler->report($exception);

        self::assertTrue(true);
    }

    public function testReportWithoutLogger(): void
    {
        $handler = new class extends ExceptionHandler {
            protected function bootBasicHandlers(): void {}
        };

        $handler->addReporter(new LoggerReporter());

        $handler->report(new \Exception());

        // any errors
        self::assertTrue(true);
    }

    protected function tearDown(): void
    {
        m::close();
    }
}
