<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Hyde\Framework\Hyde;

class HydeInstallerCommandTest extends TestCase
{
    public function test_installer_command_contains_expected_output_and_questions()
    {
        $this->artisan('install')
			->expectsOutputToContain('Hyde Installer')
			->expectsOutput('Welcome to HydePHP! Let\'s get you started! 🎉👌')
            ->expectsOutput('The installer will guide you through the process of setting up your new Hyde site!')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'no')
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')

			->expectsQuestion('Would you like to proceed?', 'yes')
            ->assertExitCode(0);
			
    }

	public function test_prompt_for_url_asks_questions_when_yes()
	{
		$url = 'https://example.org/' . uniqid();
		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'yes')
			->doesntExpectOutput('Okay, skipping setting up URL.')
			->expectsQuestion('What is the url of your site?', $url)
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')
			->expectsQuestion('Would you like to proceed?', 'yes')
            ->assertExitCode(0);
	}
			
	public function test_prompt_for_url_skips_asking_questions_when_declined()
	{
		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'no')
			->expectsOutput('Okay, skipping setting up URL.')
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')
			->expectsQuestion('Would you like to proceed?', 'yes')
            ->assertExitCode(0);
	}

	public function test_installer_can_transform_domain_into_url()
	{
		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'yes')
			->expectsQuestion('What is the url of your site?', 'example.org')
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')
			->expectsQuestion('Would you like to proceed?', 'yes')
            ->assertExitCode(0);
	}

	public function test_prompt_for_homepage_contains_expected_output_and_choices()
	{
		$this->clearIndexFile();
		
		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'no')
			->expectsOutput('Hyde has a couple different homepages to choose from.')
			->expectsQuestion('Would you like to set the index.blade.php file?', 'yes')
			->expectsChoice('Which homepage would you like to use?', 'post-feed', [
                'welcome:   Default Welcome Page',
                'post-feed: Feed of Latest Posts',
                'blank:     A Blank Layout Page',
			])
			->expectsOutput('Almost done! Here are the settings, does it look right?')
			->expectsOutput('Configured settings:')
			->expectsOutput('  homepage: post-feed')

			->expectsQuestion('Would you like to proceed?', 'yes')
            ->assertExitCode(0);
	}

	
	public function test_prompt_for_homepage_warns_when_file_already_exists()
	{
		file_put_contents(Hyde::path('resources/views/pages/index.blade.php'), '');

		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'no')
			->expectsOutput('Hyde has a couple different homepages to choose from.')
			->expectsOutputToContain('Warning: You already have a homepage file')
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')
			->expectsQuestion('Would you like to proceed?', 'yes')
            ->assertExitCode(0);
	}

	public function test_confirmation_output_is_correct()
	{
		$name = uniqid();
		$url = 'https://example.org/' . uniqid();
		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', $name)
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'yes')
			->doesntExpectOutput('Okay, skipping setting up URL.')
			->expectsQuestion('What is the url of your site?', $url)
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')
			
			->expectsOutput('Almost done! Here are the settings, does it look right?')
			->expectsOutput('Configured settings:')
			->expectsOutput('  name: ' . $name)
			->expectsOutput('  site_url: ' . $url)

			->expectsQuestion('Would you like to proceed?', 'yes')
            ->assertExitCode(0);
	}
	
	public function test_selected_settings_are_persisted_to_dotenv_when_accepting_to_proceed()
	{
		// $this->mockConsoleOutput = false;
		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'no')
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')
			->expectsQuestion('Would you like to proceed?', 'yes')
			->doesntExpectOutput('Okay, aborting.')
			->assertExitCode(0);
	}
	
	public function test_selected_settings_are_not_persisted_to_dotenv_when_declining_to_proceed()
	{
		$this->artisan('install')
			->expectsQuestion('What is the name of your site?', 'Test')
			->expectsQuestion('Do you have a domain name you\'d like to set up?', 'no')
			->expectsQuestion('Would you like to set the index.blade.php file?', 'no')
			->expectsQuestion('Would you like to proceed?', 'no')
			->expectsOutput('Okay, aborting.')
			->assertExitCode(1);
	}

	private function clearIndexFile()
	{
		if (file_exists(Hyde::path('resources/views/pages/index.blade.php'))) {
			unlink(Hyde::path('resources/views/pages/index.blade.php'));
		}
	}
}