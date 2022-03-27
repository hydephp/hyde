<?php

test('validate command can run', function () {
    $this->artisan('validate')->assertExitCode(0);
});

it('prints debug information', function () {
    $this->artisan('validate')
        ->expectsOutput('Running validation tests!')
        ->expectsOutput('All done!')
        ->assertExitCode(0);
});
