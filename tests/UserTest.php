<?php
declare(strict_types=1);

/**
 * Class UserTest
 */
final class UserTest extends BaseTest
{
    /**
     * @var
     */
    protected $userEmail;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->userEmail = getenv('ZOOM_TEST_USER') ?: '';
    }

    /**
     *
     */
    public function testCanListUsers(): void
    {
        $response = $this->client->user->listUsers();
        $this->assertGreaterThan(0, count($response->users));
    }

    /**
     *
     */
    public function testCanRetrieveUser(): void
    {
        $response = $this->client->user->retrieveUser($this->userEmail);
        $this->assertEquals($this->userEmail, $response->email);
    }

    /**
     *
     */
    public function testCanListMeetings(): void
    {
        $response = $this->client->user->listMeetings($this->userEmail);
        $this->assertNotEmpty($response);
    }
}
