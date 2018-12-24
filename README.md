# zoom-lib-php
Zoom PHP Library

## Usage

```
use Zoom\Zoom;

$apiKey = 'MY-API-KEY';
$apiSecret = 'MY-API-SECRET';

$zoom = new Zoom($apiKey, $apiSecret);
$users = $zoom->user->getUsers();

$email = 'john.doe@gmail.com';
$pageNumber = 2;
$pageSize = 50;
$meetings = $zoom->user->getMeetings($email, $pageNumber, $pageSize);

$groups = Zoom::getGroup($apiKey, $apiSecret)
    ->getGroups();

$meetingId = 1234567890;
$registrants = Zoom::getMeeting($apiKey, $apiSecret)
    ->getRegistrants($meetingId);
```

## Support
For any questions or issues, please visit our new Community Support Forum at https://devforum.zoom.us/
