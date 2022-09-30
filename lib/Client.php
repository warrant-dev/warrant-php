<?php

namespace Warrant;

require_once('vendor/autoload.php');

/**
 * Class Client.
 */
class Client {
    const VERSION = "0.1.0";

    private Config $config;
    private HttpClient\HttpClientInterface $httpClient;

    public function __construct(Config $config) {
        $this->config = $config;
        $this->httpClient = new HttpClient\HttpClient(new HttpClient\Config(
            $config->getApiKey(),
            $config->getEndpoint(),
        ));
    }

    //
    // Tenant methods
    //
    public function createTenant(Tenant $tenant): Tenant {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/tenants", data: $tenant));
        return Tenant::fromArray($json);
    }

    public function getTenant(string $tenantId): Tenant {
        $json = $this->httpClient->get(new HttpClient\RequestOptions(url: "/v1/tenants/$tenantId"));
        return Tenant::fromArray($json);
    }

    public function updateTenant(string $tenantId, Tenant $tenant): Tenant {
        $json = $this->httpClient->put(new HttpClient\RequestOptions(url: "/v1/tenants/$tenantId", data: $tenant));
        return Tenant::fromArray($json);
    }

    public function deleteTenant(string $tenantId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/tenants/$tenantId"));
    }

    //
    // User methods
    //
    public function createUser(User $user): User {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/users", data: $user));
        return User::fromArray($json);
    }

    public function getUser(string $userId): User {
        $json = $this->httpClient->get(new HttpClient\RequestOptions(url: "/v1/users/$userId"));
        return User::fromArray($json);
    }

    public function updateUser(string $userId, User $user): User {
        $json = $this->httpClient->put(new HttpClient\RequestOptions(url: "/v1/users/$userId", data: $user));
        return User::fromArray($json);
    }

    public function deleteUser(string $userId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/users/$userId"));
    }

    public function addUserToTenant(string $tenantId, string $userId): Warrant {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/tenants/$tenantId/users/$userId"));
        return Warrant::fromArray($json);
    }

    public function removeUserFromTenant(string $tenantId, string $userId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/tenants/$tenantId/users/$userId"));
    }

    //
    // Permission methods
    //
    public function createPermission(Permission $permission): Permission {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/permissions", data: $permission));
        return Permission::fromArray($json);
    }

    public function getPermission(string $permissionId): Permission {
        $json = $this->httpClient->get(new HttpClient\RequestOptions(url: "/v1/permissions/$permissionId"));
        return Permission::fromArray($json);
    }

    public function deletePermission(string $permissionId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/permissions/$permissionId"));
    }

    public function assignPermissionToRole(string $roleId, string $permissionId): Permission {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/roles/$roleId/permissions/$permissionId"));
        return Permission::fromArray($json);
    }

    public function removePermissionFromRole(string $roleId, string $permissionId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/roles/$roleId/permissions/$permissionId"));
    }

    public function assignPermissionToUser(string $userId, string $permissionId): Permission {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/users/$userId/permissions/$permissionId"));
        return Permission::fromArray($json);
    }

    public function removePermissionFromUser(string $userId, string $permissionId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/users/$userId/permissions/$permissionId"));
    }

    //
    // Role methods
    //
    public function createRole(Role $role): Role {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/roles", data: $role));
        return Role::fromArray($json);
    }

    public function getRole(string $roleId): Role {
        $json = $this->httpClient->get(new HttpClient\RequestOptions(url: "/v1/roles/$roleId"));
        return Role::fromArray($json);
    }

    public function deleteRole(string $roleId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/roles/$roleId"));
    }

    public function assignRoleToUser(string $userId, string $roleId): Role {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/users/$userId/roles/$roleId"));
        return Role::fromArray($json);
    }

    public function removeRoleFromUser(string $userId, string $roleId) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/users/$userId/roles/$roleId"));
    }

    //
    // Warrant methods
    //
    public function createWarrant(Warrant $warrant): Warrant {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/warrants", data: $warrant));
        return Warrant::fromArray($json);
    }

    public function deleteWarrant(Warrant $warrant) {
        $this->httpClient->delete(new HttpClient\RequestOptions(url: "/v1/warrants", data: $warrant));
    }

    //
    // Session methods
    //
    public function createAuthorizationSession(AuthorizationSession $session): string {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/sessions", data: $session));
        return $json['token'];
    }

    public function createSelfServiceSession(SelfServiceSession $session, string $redirectUrl): string {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v1/sessions", data: $session));
        return Config::SELF_SERVICE_DASH_URL_BASE . "/" . $json['token'] . "?redirectUrl=$redirectUrl";
    }

    //
    // Authorization methods
    //
    public function isAuthorized(WarrantCheck $warrantCheck): bool {
        if (!empty($this->config->getAuthorizeEndpoint())) {
            return $this->edgeAuthorize($warrantCheck);
        }

        return $this->authorize($warrantCheck);
    }

    public function hasPermission(PermissionCheck $permissionCheck): bool {
        return $this->isAuthorized(
            new WarrantCheck(
                WarrantCheckOp.ANY_OF,
                [new Warrant(
                    "permission",
                    $permissionCheck->getPermissionId(),
                    "member",
                    new Subject("user", $permissionCheck->getUserId())
                )],
                $permissionCheck->getConsistentRead(),
                $permissionCheck->getDebug(),
            )
        );
    }

    private function authorize(WarrantCheck $warrantCheck): bool {
        $json = $this->httpClient->post(new HttpClient\RequestOptions(url: "/v2/authorize", data: $warrantCheck));
        $warrantCheckResult = WarrantCheckResult::fromArray($json);

        return $warrantCheckResult->getCode() === 200;
    }

    private function edgeAuthorize(WarrantCheck $warrantCheck): bool {
        try {
            $json = $this->httpClient->post(new HttpClient\RequestOptions(
                baseUrl: $this->config->getAuthorizeEndpoint(),
                url: "/v2/authorize",
                data: $warrantCheck,
            ));
            $warrantCheckResult = WarrantCheckResult::fromArray($json);

            return $warrantCheckResult->getCode() === 200;
        } catch (ApiErrorException $exception) {
            if ($exception.getErrorCode() === "cache_not_ready") {
                error_log("Edge cache not ready. Re-routing access check to api.warrant.dev");
                return $this->authorize($warrantCheck);
            }
        }
    }
}
