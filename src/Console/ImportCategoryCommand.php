<?php

namespace Bamboo\ImportData\Console;

use App\Models\Category;
use Bamboo\ImportData\Models\ProductSet;
use Bamboo\ImportData\Services\PortalService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportCategoryCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import categories from old system';

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
            ProductSet::query()
                ->with('parent')
                ->each(function (ProductSet $productSet) use ($accountHolderId) {
                    $parent = $productSet->parent_id ? Category::firstWhere('name', $productSet->parent->name) : null;
                    $categoryData = array_merge(
                        $productSet->getSalesCategoryData(),
                        [
                            'account_holder_id' => $accountHolderId,
                            'parent_id' => optional($parent)->id
                        ]
                    );

                    Category::firstOrCreate(
                        Arr::only($categoryData, ['account_holder_id', 'name']),
                        $categoryData
                    );
                });
        });
    }
}
