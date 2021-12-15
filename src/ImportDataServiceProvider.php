<?php

namespace Bamboo\ImportData;

use Bamboo\ImportData\Base\Package;
use Bamboo\ImportData\Base\PackageServiceProvider;
use Bamboo\ImportData\Console\{ImportClientCommand,
    ImportDistributionListCommand,
    ImportPortalAccountHolderCommand,
    ImportPortalOrganizationCommand,
    ImportPortalUserCommand
};

class ImportDataServiceProvider extends PackageServiceProvider
{
    protected $packageName = 'bambooo/import-data';

    public function registerConfigs()
    {
        return ['app', 'import', 'database'];
    }

    public function registerCommands()
    {
        return [
            // sales
            ImportClientCommand::class,
            ImportDistributionListCommand::class,

            // portal
            ImportPortalAccountHolderCommand::class,
            ImportPortalOrganizationCommand::class,
            ImportPortalUserCommand::class,
        ];
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name($this->packageName)
            ->hasConfigFile($this->registerConfigs())
            ->hasCommands($this->registerCommands());
    }
}
