<?php

namespace Bamboo\ImportData\Console;

use App\Models\Brand;
use Bamboo\ImportData\Models\Store;
use Bamboo\ImportData\Services\PortalService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportBrandCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:brand';

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
        $organization = app(PortalService::class)->getOrganizationByName(config('import.organization_name'));
        DB::transaction(function () use ($organization) {
            Store::query()->each(function (Store $store) use ($organization) {
                $brandData = array_merge(
                    $store->getBrandData(),
                    [
                        'account_holder_id' => $organization->account_holder_id,
                        'organization_id' => $organization->getKey()
                    ]
                );

                Brand::firstOrCreate(
                    Arr::only($brandData, ['name']),
                    $brandData
                );
            });
        });
    }
}
