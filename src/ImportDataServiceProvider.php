<?php

namespace Bamboo\ImportData;

use Bamboo\ImportData\Base\Package;
use Bamboo\ImportData\Base\PackageServiceProvider;
use Bamboo\ImportData\Console\{ImportBrandCommand,
    ImportCategoryCommand,
    ImportClientCommand,
    ImportDistributionListCommand,
    ImportPortalAccountHolderCommand,
    ImportPortalOrganizationCommand,
    ImportPortalUserCommand};

class ImportDataServiceProvider extends PackageServiceProvider
{
    protected $packageName = 'bambooo/import-data';

    protected const SALES_PROJECT = 'sales';
    protected const TRACE_PROJECT = 'trace';
    protected const PORTAL_PROJECT = 'portal';
    protected const AUTH_PROJECT = 'auth';

    public function registerConfigs()
    {
        return ['app', 'import', 'database'];
    }

    public function registerCommands()
    {
        switch ($this->getProjectName())
        {
            case self::SALES_PROJECT:
                return [
                    ImportClientCommand::class,
                    ImportDistributionListCommand::class,
                    ImportCategoryCommand::class,
                    ImportBrandCommand::class,
                ];
            case self::PORTAL_PROJECT:
                return [
                    ImportPortalAccountHolderCommand::class,
                    ImportPortalOrganizationCommand::class,
                    ImportPortalUserCommand::class,
                ];
            default:
                return [];
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name($this->packageName)
            ->hasConfigFile($this->registerConfigs())
            ->hasCommands($this->registerCommands());
    }
}
