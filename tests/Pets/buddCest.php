<?php

declare(strict_types=1);


namespace Tests\Pets;

use Tests\Support\PetsTester;

final class buddCest
{
    public function _before(PetsTester $I): void
    {
        // Code here will be executed before each test.
    }

     public function getPetById(PetsTester $I)
    {
        $I->sendGet('/pet/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["id" => 1]);
    }

    public function addNewPet(PetsTester $I)
    {
        $I->sendPost('/pet', [
            "id" => 1001,
            "name" => "Buddy",
            "status" => "available"
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(["id" => 1001]);
    }

    public function deletePet(PetsTester $I)
    {
        $I->sendDelete('/pet/1001');
        $I->seeResponseCodeIs(200);
    }
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
    
    

}
