<?php

namespace Bamboo\ImportData\Console;

use App\Models\{AccountHolder, Organization};
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportPortalOrganizationCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:organization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import portal organization from old system';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function handle()
    {
        $accountHolder = AccountHolder::firstWhere('name', config('import.account_holder_name'));
        DB::transaction(function () use ($accountHolder) {
            $organizationData = [
                'name' => config('import.organization_name'),
                'account_holder_id' => $accountHolder['id'],
                'status' => 1,
            ];
            $organization = Organization::firstOrCreate(
                Arr::only($organizationData, ['name']),
                $organizationData
            );

            $organization->locations()->create([
                'account_holder_id' => $accountHolder['id'],
                'city' => '',
                'state_code' => 'WA',
                'address1' => '',
                'is_main_location' => true,
            ]);
        });
    }
}
