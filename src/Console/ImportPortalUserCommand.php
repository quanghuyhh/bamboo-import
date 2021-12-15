<?php

namespace Bamboo\ImportData\Console;

use App\Models\Organization;
use App\Models\User;
use Bamboo\ImportData\Models\User as OldUser;
use Bamboo\ImportData\Services\PortalService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportPortalUserCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'import:portal-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import portal user from old system';

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
            OldUser::query()->each(function (OldUser $oldUser) use ($accountHolderId) {
                $userData = array_merge(
                    $oldUser->getPortalUserData(),
                    [
                        'account_holder_id' => $accountHolderId
                    ]
                );
                $user = User::create($userData);

                $organizationIds = Organization::whereIn('name', $oldUser->stores()->pluck('store')->toArray());
                if (!empty($organizationIds)) {
                    $user->organizations()->sync($organizationIds);
                }
            });
        });
    }
}