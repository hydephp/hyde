<?php

namespace App\Commands;

use App\Hyde\Hyde;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class MakeValidatorCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:validator {--name= : The name of the test} {--force : Overwrite existing files}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a validator test';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Creating new Validation Test!');
        $name = $this->option('name') ?? $this->ask('What does the validator do?');
        $testName = strtolower($name);
        $slug = str_replace(' ', '', Str::title($name)) . 'Test.php';

        $content =
        "<?php

test('{$testName}', function () {
    //
})->group('validators');
";

        $path = Hyde::path("tests/Validators/$slug");

        if (file_exists($path) && !$this->option('force')) {
            $this->error('Validator already exists!');
            return 409;
        }


        file_put_contents($path, $content);

        $this->line("Created file $path");

        return 0;
    }
}
