# zoom-lib-php
Zoom PHP Library

## Usage

```
use Zoom\Client;

$apiKey = 'MY-API-KEY';
$apiSecret = 'MY-API-SECRET';

$client = new Client($apiKey, $apiSecret);

$zoomUser = $client->user;
$users = $zoomUser->listUsers();

$meetingId = 1234567890;
$zoomMeeting = $client->meeting;
$registrants = $zoomMeeting->listRegistrants($meetingId);
```

## Support
For any questions or issues, please visit our new Community Support Forum at https://devforum.zoom.us/
