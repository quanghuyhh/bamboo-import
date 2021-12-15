<?php

namespace Bamboo\ImportData\Console;

use App\Models\{AccountHolder, Module};
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Throwable;

class ImportPortalAccountHolderCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:portal-account-holder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import portal account holder';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function handle()
    {
        $accountHolderId = 'f136252a-adfd-42a9-96a1-4ece04730600';
        $faker = Factory::create();
        $accountHolderData = [
            'id' => $accountHolderId,
            'name' => "Bamboo",
            'trial_ends_at' => '2022-01-01',

            'address1' => $faker->streetAddress,
            'address2' => $faker->secondaryAddress,
            'city' => $faker->city,
            'state_code' => 'WA',
            'zip_code' => $faker->postcode,
            'employee_range' => $faker->randomElement(array_keys(AccountHolder::EMPLOYEE_RANGES)),
            'ein' => $faker->regexify('[0-9]{9}'),
            'status' => 1,
        ];
        $accountHolder = AccountHolder::firstOrCreate(
            Arr::only($accountHolderData, ['name']),
            $accountHolderData
        );
        $accountHolder->modules()->sync(Module::pluck('id')->toArray());
    }
}
