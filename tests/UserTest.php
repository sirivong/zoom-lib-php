<?php
declare(strict_types=1);

namespace ZoomTest;

use Zoom\Transformers\RawTransformer;

/**
 * Class UserTest
 */
final class UserTest extends BaseTest
{
    /**
     * @var
     */
    protected $email;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->email = getenv('ZOOM_TEST_EMAIL') ?: '';
        if (empty($this->email)) {
            throw new \Exception('ZOOM_TEST_EMAIL environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanGetUsers(): void
    {
        $response = $this->zoom->user->get();
        $this->assertGreaterThan(0, count($response->users));

        $pageNumber = 2;
        $pageSize = 1;
        $response = $this->zoom->user->get(null, null, ['page_number' => $pageNumber, 'page_size' => $pageSize]);
        $this->assertEquals($pageNumber, $response->page_number);
        $this->assertEquals($pageSize, $response->page_size);
    }

    /**
     *
     */
    public function testCanGetUser(): void
    {
        $response = $this->zoom->user->get($this->email);
        $this->assertEquals($this->email, $response->email);

        $response = $this->zoom->user->transformer(new RawTransformer())->get($this->email);
        $this->assertEquals(json_decode($response)->email, $this->email);
    }

    /**
     *
     */
    public function testCanGetSettings(): void
    {
        $response = $this->zoom->user->settings($this->email);
        $this->assertNotEmpty($response);
    }

    /**
     *
     */
    public function testEmailExisted(): void
    {
        $emailExisted = $this->zoom->user->emailExisted($this->email);
        $this->assertTrue($emailExisted);

        $invalidEmail = 'invalid-user-account@invalid-email-domain.tld';
        $emailExisted = $this->zoom->user->emailExisted($invalidEmail);
        $this->assertFalse($emailExisted);
    }
}
