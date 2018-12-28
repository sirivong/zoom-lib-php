<?php
declare(strict_types=1);

namespace ZoomTest;

/**
 * Class WebinarTest
 */
final class WebinarTest extends BaseTest
{
    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->webinarId = (int)getenv('ZOOM_TEST_WEBINAR_ID') ?: 0;
        if (!$this->webinarId) {
            throw new \Exception('ZOOM_TEST_WEBINAR_ID environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanGetWebinar(): void
    {
        $response = $this->client->webinar->webinar($this->webinarId);
        $this->assertNotNull($response);
    }
}
