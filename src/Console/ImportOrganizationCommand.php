<?php

namespace Bamboo\ImportData\Console;

use Bamboo\ImportData\Models\Store;
use Bamboo\ImportData\Services\PortalService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportOrganizationCommand extends Command
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
    protected $description = 'Import store from old system';

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
            });
        });
    }
}
