<?php

test('debug command can run', function () {
    $this->artisan('debug')->assertExitCode(0);
});

it('prints debug information', function () {
    $this->artisan('debug')
        ->expectsOutput('HydePHP Debug Screen')
        ->expectsOutputToContain('Git Version:')
        ->expectsOutputToContain('Hyde Version:')
        ->expectsOutputToContain('Framework Version:')
        ->expectsOutputToContain('App Env:')
        ->expectsOutputToContain('Project directory:')
        ->expectsOutputToContain('Enabled features:')
        ->assertExitCode(0);
});
