<?php

namespace Bamboo\ImportData\Console;

use App\Models\{AccountHolder, Module, User};
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ImportPortalAccountHolderCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:account-holder';

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
        $accountHolder = $this->createAccountHolder();

        // create user
        $this->createUser([
            'account_holder_id' => $accountHolder->getKey(),
            'roles' => ['admin']
        ]);

    }

    public function createAccountHolder(): AccountHolder
    {
        $accountHolderId = config('import.account_holder_id');
        $faker = Factory::create();

        $accountHolderData = [
            'id' => $accountHolderId,
            'name' => config('import.account_holder_name'),
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

        // create account holder
        $accountHolder = AccountHolder::firstOrNew(
            Arr::only($accountHolderData, ['name']),
            $accountHolderData
        );
        if (!$accountHolder->id) {
            $accountHolder->forceFill(Arr::only($accountHolderData, ['id']))->save();
        }
        $accountHolder->modules()->sync(Module::pluck('id')->toArray());

        return $accountHolder;
    }

    public function createUser(array $data): User
    {
        $faker = Factory::create();

        $firstName = $faker->firstName;
        $lastName = $faker->lastName;

        $userData = array_merge(
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => "{$firstName}.{$lastName}@bamboo.com",
                'phone' => $faker->phoneNumber,
                'password' => Hash::make($faker->regexify('[A-Za-z0-9]{' . mt_rand(8, 20) . '}')),
                'active' => rand(0, 1),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => rand(0, 1),
                'can_change_password' => rand(0, 1),
                'can_update_profile' => rand(0, 1),
                'can_upload_photo' => rand(0, 1),
            ],
            $data
        );

        return User::create($userData);
    }
}
