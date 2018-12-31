<?php
declare(strict_types=1);

namespace ZoomTest;

/**
 * Class WebinarTest
 */
final class WebinarTest extends BaseTest
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $webinarId;

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
        $this->webinarId = getenv('ZOOM_TEST_WEBINAR_ID') ?: '';
        if (!$this->webinarId) {
            throw new \Exception('ZOOM_TEST_WEBINAR_ID environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanGetWebinars(): void
    {
        $response = $this->zoom->webinar->getMany($this->email);
        $this->assertNotNull($response);
    }

    /**
     *
     */
    public function testCanGetWebinar(): void
    {
        $response = $this->zoom->webinar->getOne($this->webinarId);
        $this->assertNotNull($response);
    }
}
