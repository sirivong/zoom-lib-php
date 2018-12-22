<?php
declare(strict_types=1);

namespace ZoomTest;

/**
 * Class RoleTest
 */
final class RoleTest extends BaseTest
{
    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->roleId = (int)getenv('ZOOM_TEST_ROLE_ID') ?: 0;
        if (!$this->roleId) {
            throw new \Exception('ZOOM_TEST_ROLE_ID environment variable is not set.');
        }
    }

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
        $response = $this->client->role->listMembers($this->roleId);
        $this->assertGreaterThan(0, count($response->members));
    }
}