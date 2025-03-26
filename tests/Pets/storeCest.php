<?php

declare(strict_types=1);


namespace Tests\Pets;

use Tests\Support\PetsTester;

final class storeCest
{
    public function _before(PetsTester $I): void
    {
        $I->haveHttpHeader('accept', 'application/json');
    }
      //return inventories all the inventorires by statues 
    public function returnInventories(PetsTester $I) 
    {
        $I->sendGet("/store/inventory");
         // Assertions
         $I->seeResponseCodeIs(200); 
         $I->seeResponseIsJson(); 
         $I->seeResponseMatchesJsonType([
             'sold' => 'integer',
             'Pending' => 'integer'
         ]);
    }
    //place an order to get the pets 
    public function placeAnOrder(PetsTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        //Assertions 
        $orderData = [
            'id' => 0,
            'petId' => 0,
            'quantity' => 0,
            'shipDate' => '2025-03-26T08:23:25.199Z',
            'status' => 'placed',
            'complete' => true,
        ];
        $I->sendPost("/store/order", $orderData);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson([
             "status" => "placed",
             "complete" => true
      ]);
    }
    //purchase the order by Id
    public function purchaseOrder(PetsTester $I)
    { 

        $orderId = 2;
        $orderData = [
            
            'id' => $orderId,
            'petId' => 9223372036854775000,
            'quantity' => 1,
            'shipDate' => '2025-03-26T08:23:25.199Z',
            'status' => 'placed',
            'complete' => true,
        ];
       
       $I->sendGet("/store/order/$orderId");
       $I->seeResponseCodeIs(200);

       $I->seeResponseContainsJson([
            "id" => $orderId,  
            "status" => "placed",
            "complete" => true
        ]);
    }
      //Delete purchase by id 
    public function deleteOrder(PetsTester $I)
    {  
        $orderId = 2;
        $I->sendDelete("/store/order/$orderId");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson([
            "code" => "200",
            "type" => "unknown",
            "message" => $orderId

        ]);
    }

}
