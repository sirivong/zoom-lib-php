<?php
declare(strict_types=1);

namespace ZoomTest;

/**
 * Class RoleTest
 */
final class RoleTest extends BaseTest
{
    /**
     *
     */
    public function testCanListRoles(): void
    {
        $response = $this->client->role->listRoles();
        $this->assertGreaterThan(0, count($response->roles));
    }

    /**
     *
     */
    public function testCanListMembers(): void
    {
        $roleId = getenv('ZOOM_TEST_ROLE_ID') ?: 1;
        $response = $this->client->role->listMembers($roleId);
        $this->assertGreaterThan(0, count($response->members));
    }
}