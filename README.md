# zoom-lib-php
Zoom PHP Library

## Usage

```
use Zoom\Zoom;
use Zoom\Transformers\RawTransformer;

$apiKey = 'MY-API-KEY';
$apiSecret = 'MY-API-SECRET';

$zoom = new Zoom($apiKey, $apiSecret);
$users = $zoom->user->users();

$email = 'john.doe@gmail.com';
$pageNumber = 2;
$pageSize = 50;
$meetings = $zoom->user->meetings($email, $pageNumber, $pageSize);

$groups = Zoom::Group($apiKey, $apiSecret)
    ->groups();

$meetingId = 1234567890;
$registrants = Zoom::Meeting($apiKey, $apiSecret)
    ->transformer(new RawTransformer())
    ->registrants($meetingId);
```

## Support
For any questions or issues, please visit our new Community Support Forum at https://devforum.zoom.us/
