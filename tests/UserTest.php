<?php
declare(strict_types=1);

namespace ZoomTest;

use GuzzleHttp\Exception\ClientException;

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
    public function testCanGetUsers(): void
    {
        $response = $this->client->user->getUsers();
        $this->assertGreaterThan(0, count($response->users));

        $pageNumber = 2;
        $pageSize = 1;
        $response = $this->client->user->getUsers($pageNumber, $pageSize);
        $this->assertEquals($pageNumber, $response->page_number);
        $this->assertEquals($pageSize, $response->page_size);
    }

    /**
     *
     */
    public function testCanGetUser(): void
    {
        $response = $this->client->user->getUser($this->userEmail);
        $this->assertEquals($this->userEmail, $response->email);
    }

    /**
     *
     */
    public function testCanGetMeetings(): void
    {
        $response = $this->client->user->getMeetings($this->userEmail);
        $this->assertNotEmpty($response);
    }

    /**
     *
     */
    public function testCanGetWebinars(): void
    {
        try {
            $response = $this->client->user->getWebinars($this->userEmail);
            $this->assertNotEmpty($response);
        } catch (ClientException $ce) {
        }
    }

    /**
     *
     */
    public function testCanGetSettings(): void
    {
        $response = $this->client->user->getSettings($this->userEmail);
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
