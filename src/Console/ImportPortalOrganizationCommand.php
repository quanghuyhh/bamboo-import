<?php

namespace Bamboo\ImportData\Console;

use App\Models\Organization;
use Bamboo\ImportData\Models\Store;
use Bamboo\ImportData\Services\PortalService;
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
    protected $signature = 'import:portal-organization';

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
        $accountHolderId = app(PortalService::class)->getAccountHolderId();
        DB::transaction(function () use ($accountHolderId) {
            Store::query()->each(function (Store $store) use ($accountHolderId) {
                $organizationData = array_merge(
                    $store->getOrganizationData(),
                    [
                        'account_holder_id' => $accountHolderId,
                    ]
                );

                $organization = Organization::firstOrCreate(
                    Arr::only($organizationData, ['name']),
                    $organizationData
                );

                $locationData = array_merge(
                    $store->getOrganizationLocationData(),
                    [
                        'account_holder_id' => $accountHolderId,
                    ]
                );
                $organization->locations()->create($locationData);
            });
        });
    }
}