<?php

namespace Hyde\Testing;

use Hyde\Framework\Hyde;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use Throwable;

class TestListener implements \PHPUnit\Framework\TestListener
{
    public function addError(Test $test, Throwable $t, float $time): void
    {
        //
    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {
        //
    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
        //
    }

    public function addIncompleteTest(Test $test, Throwable $t, float $time): void
    {
        //
    }

    public function addRiskyTest(Test $test, Throwable $t, float $time): void
    {
        //
    }

    public function addSkippedTest(Test $test, Throwable $t, float $time): void
    {
        //
    }

    public function startTestSuite(TestSuite $suite): void
    {
        //
    }

    public function endTestSuite(TestSuite $suite): void
    {
        unlinkIfExists(Hyde::path('_site/index.html'));
        unlinkIfExists(Hyde::path('_site/404.html'));
        unlinkIfExists(Hyde::path('_site/media/app.css'));
    }

    public function startTest(Test $test): void
    {
        //
    }

    public function endTest(Test $test, float $time): void
    {
        //
    }
}
