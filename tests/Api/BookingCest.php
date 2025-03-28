<?php

declare(strict_types=1);


namespace Tests\Api;

use Tests\Support\ApiTester;

final class BookingCest
{
    private string $token; // Class property to store the token
    private int $bookingId; // Class property to store the booking ID

    public function _before(ApiTester $I): void
    {
        
    }

    public function getAllBookings(ApiTester $I): void
    {
        $I->sendGet('/booking');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'bookingid' => 'integer'
        ], '$[*]');
    }
    public function createBooking(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json'); // Ensure correct response type

        $payload = [
            'firstname' => 'De Ngassa ',
            'lastname' => 'Brandon ',
            'totalprice' => 150,
            'depositpaid' => true,
            'bookingdates' => [
                'checkin' => '2024-01-01',
                'checkout' => '2024-01-05'
            ],
            'additionalneeds' => 'Breakfast'
        ];

        $I->sendPost('/booking', params: $payload);

        codecept_debug($I->grabResponse());

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'bookingid' => 'integer',
            'booking' => [
                'firstname' => 'string',
                'lastname' => 'string',
                'totalprice' => 'integer',
                'depositpaid' => 'boolean',
                'bookingdates' => [
                    'checkin' => 'string',
                    'checkout' => 'string'
                ],
                'additionalneeds' => 'string'
            ]
        ]);

        // Store the booking ID in the class property
        $this->bookingId = $I->grabDataFromResponseByJsonPath('$.bookingid')[0];
    }
    public function authenticateTheCreatedUser(ApiTester $I)
    {
        $payload = [
            "username" => "admin",
            "password" => "password123"
        ];

        $I->sendPost('/auth', $payload);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'token' => 'string'
        ]);
        $this->token = $I->grabDataFromResponseByJsonPath('$.token')[0];
    }
    public function updateBooking(ApiTester $I)
    { 
        $bookId = $this->bookingId; 
        // Ensure the token is set
        if (!isset($this->token)) {
            $this->authenticateUser($I); // Authenticate and retrieve the token if not already set
        }

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'token=' . $this->token);

        $payload = [
            'firstname' => 'Brandon',
            'lastname' => 'Yess',
            'totalprice' => 200,
            'depositpaid' => false,
            'bookingdates' => [
                'checkin' => '2024-02-01',
                'checkout' => '2024-02-10'
            ],
            'additionalneeds' => 'Lunch'
        ];

        $I->sendPut('/booking/' . $bookId, $payload);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->comment($I->grabResponse());
        $I->seeResponseMatchesJsonType([
            'firstname' => 'string',
            'lastname' => 'string',
            'totalprice' => 'integer',
            'depositpaid' => 'boolean',
            'bookingdates' => [
                'checkin' => 'string',
                'checkout' => 'string'
            ],
            'additionalneeds' => 'string'
        ]);
    }
}
