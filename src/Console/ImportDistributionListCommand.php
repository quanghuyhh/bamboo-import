<?php

namespace Bamboo\ImportData\Console;

use App\Models\Distribution;
use Bamboo\ImportData\Models\ClientBucket;
use Bamboo\ImportData\Services\PortalService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportDistributionListCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:distribution';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import distribution list from old system';

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
            ClientBucket::query()->each(function (ClientBucket $clientBucket) use ($accountHolderId) {
                // get client data
                $distributionData = array_merge(
                    $clientBucket->getDistributionListData(),
                    [
                        'account_holder_id' => $accountHolderId,
                        'state_code' => 'WA'
                    ]
                );
                Distribution::firstOrCreate(
                    Arr::only($distributionData, ['name']),
                    $distributionData
                );
            });
        });
    }
}
