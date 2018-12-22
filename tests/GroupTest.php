<?php
declare(strict_types=1);

namespace ZoomTest;

/**
 * Class GroupTest
 */
final class GroupTest extends BaseTest
{
    protected $groupId;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->groupId = getenv('ZOOM_TEST_GROUP_ID') ?: '';
        if (!$this->groupId) {
            throw new \Exception('ZOOM_TEST_GROUP_ID environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanListGroups(): void
    {
        $response = $this->client->group->listGroups();
        $this->assertGreaterThan(0, count($response->groups));
    }

    /**
     *
     */
    public function testCanRetrieveGroup(): void
    {
        $response = $this->client->group->retrieveGroup($this->groupId);
        $this->assertNotNull($response);
    }
}
