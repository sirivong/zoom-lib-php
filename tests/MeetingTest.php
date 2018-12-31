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
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $meetingId;

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
        $this->meetingId = getenv('ZOOM_TEST_MEETING_ID') ?: '';
        if (!$this->meetingId) {
            throw new \Exception('ZOOM_TEST_MEETING_ID environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanGetMeetings(): void
    {
        try {
            $response = $this->zoom->meeting->getMany($this->email);
            $this->assertNotNull($response);
        } catch (ClientException $ce) {
        }
    }

    /**
     *
     */
    public function testCanGetMeeting(): void
    {
        try {
            $response = $this->zoom->meeting->getOne($this->meetingId);
            $this->assertNotNull($response);
        } catch (ClientException $ce) {
        }
    }

    /**
     *
     */
    public function testCanGetRegistrants(): void
    {
        try {
            $meeting = $this->zoom->meeting->registrants($this->meetingId);
            $this->assertNotNull($meeting);
        } catch (ClientException $ce) {
        }
    }
}
