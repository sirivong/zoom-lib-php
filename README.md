# zoom-lib-php
Zoom PHP Library

## Usage

```
use Zoom\Zoom;
use Zoom\Transformers\RawTransformer;

$apiKey = 'MY-API-KEY';
$apiSecret = 'MY-API-SECRET';

$zoom = new Zoom($apiKey, $apiSecret);
$users = $zoom->user->getMany();

$email = 'jane.doe@gmail.com';
$user = Zoom::User($apiKey, $apiSecret)->getOne($email);

$groups = Zoom::Group($apiKey, $apiSecret)->getMany();

$email = 'john.doe@gmail.com';
$query = [
    'page_number' => 2,
    'page_size' => 50,
];
$meetings = $zoom->meeting->getMany($email, $query);

$meetingId = 1234567890;
$registrants = Zoom::Meeting($apiKey, $apiSecret)
    ->transformer(new RawTransformer())
    ->registrants($meetingId);
```

## Support
For any questions or issues, please visit our new Community Support Forum at https://devforum.zoom.us/
