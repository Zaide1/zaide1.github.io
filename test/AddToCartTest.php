<?php

use PHPUnit\Framework\TestCase;

class AddToCartTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = require '/../connect_database.php';
    }

    public function testAddItemToCart()
    {
        $itemId = 1; 
        $quantity = 1; 
        $_POST['itemId'] = $itemId;
        $_POST['quantity'] = $quantity;

        include '/../add_to_cart.php';
        $stmt = $this->pdo->prepare("SELECT * FROM cart WHERE item_id = :itemId");
        $stmt->execute([':itemId' => $itemId]);
        $result = $stmt->fetch();

        $this->assertNotFalse($result, 'Item was not added to the cart.');
        $this->assertEquals($quantity, $result['quantity'], 'Quantity does not match.');
    }

    protected function tearDown(): void
    {
        $this->pdo->exec("DELETE FROM cart WHERE item_id = 1");
    }
}
