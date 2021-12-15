<?php

namespace Bamboo\ImportData\Console;

use App\Models\Client;
use App\Models\Distribution;
use Bamboo\ImportData\Models\Client as OldClient;
use Bamboo\ImportData\Services\PortalService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportClientCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import clients from old system';

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
        $distributionList = Distribution::get(['id', 'name']);
        DB::transaction(function () use ($distributionList, $accountHolderId) {
            OldClient::query()->each(function (OldClient $oldClient) use ($distributionList, $accountHolderId) {
                // find distribution
                $distribution = $distributionList->firstWhere('name', $oldClient->distributionList->name);
                // create client
                $clientData = array_merge(
                    $oldClient->getClientData(),
                    [
                        'account_holder_id' => $accountHolderId,
                        'state_code' => $oldClient->getClientState($oldClient->state) ?? 'WA',
                        'distribution_id' => optional($distribution)->id
                    ]
                );

                $client = Client::firstOrCreate(
                    Arr::only($clientData, ['email']),
                    $clientData
                );

                // create client contact
                $client->contacts()->createMany($oldClient->getClientContactsData());
            });
        });
    }
}
