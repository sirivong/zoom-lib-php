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
    public function testCanGetRoles(): void
    {
        $response = $this->client->role->getRoles();
        $this->assertGreaterThan(0, count($response->roles));
    }

    /**
     *
     */
    public function testCanGetMembers(): void
    {
        $response = $this->client->role->getMembers($this->roleId);
        $this->assertGreaterThan(0, count($response->members));
    }
}