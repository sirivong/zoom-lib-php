<?php
declare(strict_types=1);

namespace ZoomTest;

use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;

/**
 * Class RecordingTest
 */
final class RecordingTest extends BaseTest
{
    /**
     * @var
     */
    protected $meetingId;

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
        $this->meetingId = getenv('ZOOM_TEST_MEETING_ID') ?: '';
        if (!$this->meetingId) {
            throw new \Exception('ZOOM_TEST_MEETING_ID environment variable is not set.');
        }
        $this->userEmail = getenv('ZOOM_TEST_EMAIL') ?: '';
        if (empty($this->userEmail)) {
            throw new \Exception('ZOOM_TEST_EMAIL environment variable is not set.');
        }
    }

    /**
     *
     */
    public function testCanGetRecordings(): void
    {
        $from = Carbon::parse('yesterday')->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
        $response = $this->client->recording->getRecordings($this->userEmail, $from, $to);
        $this->assertNotNull($response);
    }

    /**
     *
     */
    public function testCanGetMeetingRecordings(): void
    {
        try {
            $response = $this->client->recording->getMeetingRecordings($this->meetingId);
            $this->assertGreaterThan(0, count($response->meetings));
        } catch (ClientException $ce) {
        }
    }
}
