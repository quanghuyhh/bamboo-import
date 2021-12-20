<?php

namespace Bamboo\ImportData\Console;

use App\Models\Client;
use App\Models\Distribution;
use Bamboo\ImportData\Models\Client as OldClient;
use Bamboo\ImportData\Services\PortalService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $accountHolder = app(PortalService::class)->getAccountHolderByName(config('import.account_holder_name'));
        $distributionList = Distribution::get(['id', 'name']);
        $users = app(PortalService::class)->fetchAllUsers();
        DB::transaction(function () use ($distributionList, $accountHolder, $users) {
            OldClient::query()->each(function (OldClient $oldClient) use ($distributionList, $accountHolder, $users) {
                // find distribution
                $distribution = !empty($oldClient->distributionList) ? $distributionList->firstWhere('name', $oldClient->distributionList->name) : null;

                // find sales rep
                $salesRep = !empty($oldClient->salesRep) ? $users->firstWhere('email', $oldClient->salesRep->email) : null;

                // find vmi rep
                $vmiRep = !empty($oldClient->vmiRep) ? $users->firstWhere('email', $oldClient->vmiRep->email) : null;

                // create client
                $clientData = array_merge(
                    $oldClient->getClientData(),
                    [
                        'account_holder_id' => $accountHolder->getKey(),
                        'distribution_id' => optional($distribution)->id,
                        'field_rep_id' => optional($salesRep)->id,
                        'vmi_rep_id' => optional($vmiRep)->id,
                    ]
                );
                if (Client::where('email', $clientData['email'])->count()) {
                    $clientData['email'] = Str::replace(
                        '@',
                        '+' . $oldClient->id,
                        $clientData['email']
                    );
                }

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
