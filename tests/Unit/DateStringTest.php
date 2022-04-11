<?php

namespace Tests\Unit;

use DateTime;
use Hyde\Framework\Models\DateString;
use PHPUnit\Framework\TestCase;

class DateStringTest extends TestCase
{
    // Test it can parse a date string
    public function test_it_can_parse_date_string()
    {
        $dateString = new DateString('2020-01-01');
        $this->assertEquals('2020-01-01', $dateString->string);
    }

    // Test it can parse date string into datetime object
    public function test_it_can_parse_date_string_into_datetime_object()
    {
        $dateString = new DateString('2020-01-01 UTC');
        $this->assertInstanceOf(DateTime::class, $dateString->dateTimeObject);
    }

    // Test it can format date string into a machine-readable string
    public function test_it_can_format_date_string_into_machine_readable_string()
    {
        $dateString = new DateString('2020-01-01 UTC');
        $this->assertEquals('2020-01-01T00:00:00+00:00', $dateString->datetime);
    }

    // Test it can format date string into a human-readable string
    public function test_it_can_format_date_string_into_human_readable_string()
    {
        $dateString = new DateString('2020-01-01 UTC');
        $this->assertEquals('Wednesday Jan 1st, 2020, at 12:00am', $dateString->sentence);
    }

    // Test it can format date string into a short human-readable string
    public function test_it_can_format_date_string_into_short_human_readable_string()
    {
        $dateString = new DateString('2020-01-01 UTC');
        $this->assertEquals('Jan 1st, 2020', $dateString->short);
    }
}
