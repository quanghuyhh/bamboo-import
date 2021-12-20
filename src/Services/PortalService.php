<?php

namespace Bamboo\ImportData\Services;

use App\Models\Organization;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PortalService
{
    private string $baseUrl;
    private string $userPath;
    private string $organizationPath;
    private string $accountHolderPath;
    private PendingRequest $request;

    public function __construct()
    {
        $this->baseUrl = config('app.services.portal.base_url');
        $this->userPath = config('app.services.portal.paths.user');
        $this->organizationPath = config('app.services.portal.paths.organization');
        $this->accountHolderPath = config('app.services.portal.paths.account_holder');
        # TODO: Remove verify when on prod env
        $this->request = Http::withoutVerifying()->baseUrl($this->baseUrl);
    }

    /**
     * @param array $list
     * @param string $class
     *
     * @return Collection
     */
    private function collect(array $list, string $class): Collection
    {
        $collection = collect();
        foreach ($list as $item) {
            /** @var Model $instance */
            $instance = new $class();
            $instance->forceFill($item);
            $collection->put($instance->id, $instance);
        }

        return $collection;
    }

    /**
     * @return Collection
     *
     * @throws Exception
     */
    public function fetchAllUsers(): Collection
    {
        return $this->collect($this->getUsers(), User::class);
    }

    /**
     * @param array $filters
     * @param array $selectedFields
     * @return array
     *
     * @throws Exception
     */
    public function getUsers(array $filters = [], array $selectedFields = []): array
    {
        $response = $this->request->get($this->userPath . 'all', ['filter' => $filters, 'select' => $selectedFields]);
        if ($response->failed()) {
            throw new Exception(__('exceptions.portal_service.fetch_users_failed'));
        }

        return $response->json();
    }

    public function getAccountHolders(array $filters = [], array $selectedFields = []): array
    {
        $response = $this->request->get($this->accountHolderPath . 'index', ['filter' => $filters, 'select' => $selectedFields]);
        if ($response->failed()) {
            throw new Exception(__('exceptions.portal_service.fetch_account_holder_failed'));
        }

        return $response->json();
    }

    public function getAccountHolderByName(string $name): array
    {
        $accountHolders = $this->getAccountHolders(['name' => $name]);
        return collect($accountHolders)->first();
    }

    public function getOrganizations(array $filters = [], array $selectedFields = []): Collection
    {
        $response = $this->request->get($this->organizationPath, ['filter' => $filters, 'select' => $selectedFields]);
        if ($response->failed()) {
            throw new Exception(__('exceptions.portal_service.fetch_organizations_failed'));
        }

        return $this->collect($response->json(), Organization::class);
    }

    public function getOrganizationByName(string $name): Organization
    {
        return $this->getOrganizations(['name' => $name], ['account_holder_id'])->first();
    }
}
