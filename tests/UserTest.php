<?php
declare(strict_types=1);

namespace ZoomTest;

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
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->userEmail = getenv('ZOOM_TEST_EMAIL') ?: '';
        if (empty($this->userEmail)) {
            throw new \Exception('ZOOM_TEST_EMAIL environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanListUsers(): void
    {
        $response = $this->client->user->listUsers();
        $this->assertGreaterThan(0, count($response->users));

        $pageNumber = 2;
        $pageSize = 1;
        $response = $this->client->user->listUsers(null, $pageNumber, $pageSize);
        $this->assertEquals($pageNumber, $response->page_number);
        $this->assertEquals($pageSize, $response->page_size);
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

    /**
     *
     */
    public function testCanRetrieveSettings(): void
    {
        $response = $this->client->user->retrieveSettings($this->userEmail);
        $this->assertNotEmpty($response);
    }

    /**
     *
     */
    public function testCanCheckEmail(): void
    {
        $response = $this->client->user->checkEmail($this->userEmail);
        $this->assertTrue($response->existed_email);

        $invalidEmail = 'invalid-user-account@invalid-email-domain.tld';
        $response = $this->client->user->checkEmail($invalidEmail);
        $this->assertFalse($response->existed_email);
    }
}
