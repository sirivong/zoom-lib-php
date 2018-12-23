# zoom-lib-php
Zoom PHP Library

## Usage

```
use Zoom\Client;

$apiKey = 'MY-API-KEY';
$apiSecret = 'MY-API-SECRET';

$client = new Client($apiKey, $apiSecret);
$users = $client->user->getUsers();

$email = 'john.doe@gmail.com';
$pageNumber = 2;
$pageSize = 50;
$meetings = $client->user->getMeetings($email, $pageNumber, $pageSize);

$groups = Client::getGroup($apiKey, $apiSecret)
    ->getGroups();

$meetingId = 1234567890;
$registrants = Client::getMeeting($apiKey, $apiSecret)
    ->getRegistrants($meetingId);
```

## Support
For any questions or issues, please visit our new Community Support Forum at https://devforum.zoom.us/
