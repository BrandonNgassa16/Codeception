<?php

declare(strict_types=1);


namespace Tests\Pets;

use Tests\Support\PetsTester;

final class buddCest
{
   
    public function _before(PetsTester $I): void
    {
        $I->haveHttpHeader('Accept', 'application/json');
    }
        //Find the Pets ID
     public function getPetById(PetsTester $I)
    {
        $I->sendGet('/pet/123');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["id" => 123]);
    }
    //Upload an Image Find in the Pets Store
    public function uploadImage(PetsTester $I)
    {
      $petId = '123';
      $headers = [
        'Content-Type' => 'multipart/form-data',
        'accept' => 'application/json'
    ];

    $fileToUpload = [
        "name" => 'uploadedfile.pdf',
        "type" => "application/pdf",
        "size" => filesize(codecept_data_dir('uploadedfile.pdf')),
        "tmp_name" => codecept_data_dir('uploadedfile.pdf')
    ];

    $I->sendPost("/pet/$petId/uploadImage", $headers, [
        'file' => $fileToUpload
     ]);
    $I->seeResponseCodeIs(200);
    $I->seeResponseIsJson();
    
    }
    //Function to Add New pet to the store  
    public function addPet(PetsTester $I)
    {
        $petData = [
            "id" => 0,
            "category" => [
                "id" => 0,
                "name" => "string"
            ],
            "name" => "doggie",
            "photoUrls" => [
                "string"
            ],
            "tags" => [
                [
                    "id" => 0,
                    "name" => "string"
                ]
            ],
            "status" => "available"
        ];
    
        // Set headers
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/pet', json_encode($petData));
    
        codecept_debug($I->grabResponse());
    
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "name" => "doggie",
            "status" => "available"
        ]);
    }

       //Updates a pet  in the store with form data 
    public function updateThePet(PetsTester $I)
    {
        $petData = [
            "id" => 0,
            "category" => [
                "id" => 0,
                "name" => "string"
            ],
            "name" => "doggie",
            "photoUrls" => [
                "string"
            ],
            "tags" => [
                [
                    "id" => 0,
                    "name" => "string"
                ]
            ],
            "status" => "available"
        ];
    
        // Set headers
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/pet', json_encode($petData));
        codecept_debug($I->grabResponse());
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "name" => "doggie",
            "status" => "available"
        ]);
    }

    //Finds Pet by statues
    public function getPetsByStatus(PetsTester $I)
    {
        $status = 'available';
        $I->sendGet('/pet/findByStatus', ['status' => $status]);

        $I->seeResponseCodeIs(200); 
        $I->seeResponseIsJson(); 
        $I->seeResponseMatchesJsonType([], '$[*]'); // Validate the structure of each item in the response
    }

    //Updates a pet in the store  with form data 
     public function updatePetId(PetsTester $I)
     {

        $petId = 123;
        
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $formData = [
            'name' => 'posting',
            'status' => 'ok'
        ];
        $I->sendPost("/pet/$petId", $formData);
        codecept_debug($I->grabResponse());

        // Assertions
        $I->seeResponseCodeIs(404); 
        $I->seeResponseIsJson(); 
        $I->seeResponseContainsJson([
            'code' => '404',
            'type' => 'unknown'
        ]);
        
     }
       //Deletes Pets 
     public function deletePetById(PetsTester $I)
     {
        $petId = 123;
        $I->haveHttpHeader('api_key', '123456');
        $I->sendDelete("/pet/$petId");

         codecept_debug($I->grabResponse());

        // Assertions
        $I->seeResponseCodeIs(404); 
        $response = $I->grabResponse();
        $I->assertEmpty($response, 'The response body is not empty');
    
    }
     
}