<?php

namespace Bamboo\ImportData\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class PortalService
{
    private string $baseUrl;
    private string $userPath;
    private string $organizationPath;
    private PendingRequest $request;

    public function __construct()
    {
        $this->baseUrl = config('app.services.portal.base_url');
        $this->userPath = config('app.services.portal.paths.user');
        $this->organizationPath = config('app.services.portal.paths.organization');
        # TODO: Remove verify when on prod env
        $this->request = Http::withoutVerifying()->baseUrl($this->baseUrl);
    }

    public function getAccountHolderId()
    {
        return config('import.account_holder_id');
    }
}
