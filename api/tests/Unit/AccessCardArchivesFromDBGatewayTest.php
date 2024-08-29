<?php
include 'src/config/config.php';
use deckbuilder_archive_php_version_only\api\DTOs\CardModelDTO;
use PHPUnit\Framework\TestCase;
use deckbuilder_archive_php_version_only\api\gateways\AccessCardArchivesFromDBGateway;

class AccessCardArchivesFromDBGatewayTest extends TestCase
{
    /** @test */
    private $gateway;

    protected function setUp(): void
    {
        $this->gateway = new AccessCardArchivesFromDBGateway(
            DBHost,
            DBName,
            DBUsername,
            DBPasword
        );
    }

    public function test_get_card_by_id()
    {
        $cardId = "2X2094";

        $expectedData = new CardModelDTO();

        $expectedData->cardName = "Surgical Extraction";
        $expectedData->cardId = "2X2094";
        $expectedData->cardType = "Instant";
        $expectedData->subType = null;
        $expectedData->superType = null;
        $expectedData->manaValue = "{-B}";
        $expectedData->cost = 1;
        $expectedData->url = "http://localhost/deckbuilder_archive_php_version_only/api/?action=filterbyid&cardid=2X2094";

        $result = $this->gateway->getCardsById($cardId);

        $mappedResult = CardModelDTO::map($result[0], "http://localhost/deckbuilder_archive_php_version_only/api/");

        $this->assertNotEmpty($result, 'Das Ergebnis ist leer, obwohl mindestens ein Eintrag erwartet wird.');
        $this->assertInstanceOf(CardModelDTO::class, $mappedResult);
    
        $this->assertEquals($expectedData->cardName, $mappedResult->cardName);
        $this->assertEquals($expectedData->cardId, $mappedResult->cardId);
        $this->assertEquals($expectedData->cardType, $mappedResult->cardType);
        $this->assertEquals($expectedData->subType, $mappedResult->subType);
        $this->assertEquals($expectedData->superType, $mappedResult->superType);
        $this->assertEquals($expectedData->manaValue, $mappedResult->manaValue);
        $this->assertEquals($expectedData->cost, $mappedResult->cost);
        $this->assertEquals($expectedData->url, $mappedResult->url);

    }

    public function test_get_cards_by_name()
    {
        $cardName = "Ragavan";
    
        $expectedData = new CardModelDTO();
        $expectedData->cardName = "Ragavan, Nimble Pilferer"; 
        $expectedData->cardId = "MH2138"; 
        $expectedData->cardType = "Creature"; 
        $expectedData->subType = "Monkey Pirate"; 
        $expectedData->superType = "Legendray"; 
        $expectedData->manaValue = "{R}"; 
        $expectedData->cost = 1; 
        $expectedData->url = "http://localhost/deckbuilder_archive_php_version_only/api/?action=filterbyid&cardid=MH2138";
    
        $result = $this->gateway->getCardsByName($cardName);
    
        $mappedResult = CardModelDTO::map($result[0], "http://localhost/deckbuilder_archive_php_version_only/api/");
    
        $this->assertNotEmpty($result, 'Das Ergebnis ist leer, obwohl mindestens ein Eintrag erwartet wird.');
        $this->assertInstanceOf(CardModelDTO::class, $mappedResult);
    
        $this->assertEquals($expectedData->cardName, $mappedResult->cardName);
        $this->assertEquals($expectedData->cardId, $mappedResult->cardId);
        $this->assertEquals($expectedData->cardType, $mappedResult->cardType);
        $this->assertEquals($expectedData->subType, $mappedResult->subType);
        $this->assertEquals($expectedData->superType, $mappedResult->superType);
        $this->assertEquals($expectedData->manaValue, $mappedResult->manaValue);
        $this->assertEquals($expectedData->cost, $mappedResult->cost);
        $this->assertEquals($expectedData->url, $mappedResult->url);
    }
    
}
