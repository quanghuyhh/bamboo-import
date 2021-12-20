<?php

namespace Bamboo\ImportData\Console;

use App\Models\{Organization, User};
use Bamboo\ImportData\Models\User as OldUser;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
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
        $organization = Organization::firstWhere('name', config('import.organization_name'));
        DB::transaction(function () use ($organization) {
            OldUser::where('is_field_rep', true)
                ->each(function (OldUser $oldUser) use ($organization) {
                    $userData = array_merge(
                        $oldUser->getPortalUserData(),
                        [
                            'account_holder_id' => $organization->account_holder_id
                        ]
                    );
                    $user = User::firstOrCreate(
                        Arr::only($userData, ['email']),
                        $userData
                    );

                    $user->organizations()->sync([$organization->getKey()]);
                });
        });
    }
}
