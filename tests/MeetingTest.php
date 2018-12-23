<?php
declare(strict_types=1);

namespace ZoomTest;

use GuzzleHttp\Exception\ClientException;

/**
 * Class MeetingTest
 */
final class MeetingTest extends BaseTest
{
    /**
     * @var
     */
    protected $meetingId;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->meetingId = (int)getenv('ZOOM_TEST_MEETING_ID') ?: 0;
        if (!$this->meetingId) {
            throw new \Exception('ZOOM_TEST_MEETING_ID environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanGetRegistrants(): void
    {
        try {
            $meeting = $this->client->meeting->getRegistrants($this->meetingId);
            $this->assertGreaterThan(0, count($meeting->registrants));
        } catch (ClientException $ce) {
        }
    }
}