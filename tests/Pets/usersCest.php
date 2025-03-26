<?php

declare(strict_types=1);


namespace Tests\Pets;

use Tests\Support\PetsTester;

final class usersCest
{
    
    public function _before(PetsTester $I): void
    {
        $I->haveHttpHeader('accept', 'application/json');
    }

    //Operations about the user 
    public function getUserByUsername(PetsTester $I): void
    {
          $I->sendGet("/user/brandon");
          $I->seeResponseCodeIs(404);
          $I->seeResponseIsJson();
          $I->seeResponseContainsJson([
            'type' => 'error',
            'message' => 'User not found'
        ]);

        
    }
    public function updateUser(PetsTester $I)
    {

        $username = 'brandon';
        $I->haveHttpHeader('Content-Type', 'application/json');
        // Define the request body
        $data = [
            "id" => 0,
            "username" => "string",
            "firstName" => "string",
            "lastName" => "string",
            "email" => "string",
            "password" => "string",
            "phone" => "string",
            "userStatus" => 0
        ];
        $I->sendPut("user/$username", $data);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            "code" => "integer",
            "type" => "string",
            "message" => "string"
           
        ]);
        
    }
    public function deleteUser(PetsTester $I)
    { 
        $username = 'brandon';
        $I->sendDelete("/user/$username");
        $I->seeResponseCodeIs(404);


    }
    public function autheticateUser(PetsTester $I)
    {
      $credentials = [
        "username" => "testing123",
        'password' => " password123"
      ];
      $I->sendGet("/user/login", $credentials);
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();
      $I->seeResponseMatchesJsonType([
          'message' => 'string'
      ]);
    }

    public function logOutUser (PetsTester $I)
    {
      $credentials = [
            "username" => "testing123",
            'password' => " password123"
        ];
      $I->sendGet("/user/logout", $credentials);
      $I->seeResponseCodeIs(200);
      $I->seeResponseIsJson();
      $I->seeResponseIsJson([
      
        "message" =>  "ok"

      ]);
     
    }

    public function createWithArray (PetsTester $I)
    {

        $I->haveHttpHeader('Content-Type', 'application/json');
        // Define the request body
        $data = [
            "id" => 0,
            "username" => "string",
            "firstName" => "string",
            "lastName" => "string",
            "email" => "string",
            "password" => "string",
            "phone" => "string",
            "userStatus" => 0
        ];
        $I->sendPost("/user/createWithArray");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseIsJson([
        
          "message" =>  "ok"
  
        ]);
    }
    public function createUser (PetsTester $I)
    {

        $I->haveHttpHeader('Content-Type', 'application/json');
        // Define the request body
        $data = [
            "id" => 0,
            "username" => "string",
            "firstName" => "string",
            "lastName" => "string",
            "email" => "string",
            "password" => "string",
            "phone" => "string",
            "userStatus" => 0
        ];
        $I->sendPost("/user", $data);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'message' => 'string'
        ]);
    }
}
