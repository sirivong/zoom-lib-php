<?php
declare(strict_types=1);

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
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->meetingId = (int)getenv('ZOOM_MEETING_ID') ?: 0;
    }

    /**
     *
     */
    public function testCanListRegistrants(): void
    {
        try {
            $meeting = $this->client->meeting->listRegistrants($this->meetingId);
            $this->assertGreaterThan(0, count($meeting->registrants));
        } catch (ClientException $ce) {
        }
    }
}