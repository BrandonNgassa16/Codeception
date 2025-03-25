<?php


namespace Tests\Pets;

use Tests\Support\PetsTester;

class PetCest
{
    public function _before(PetsTester $I): void
    {
        
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
}
