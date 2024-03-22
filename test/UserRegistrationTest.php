<?php
use PHPUnit\Framework\TestCase;

class UserRegistrationTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = require __DIR__ . '/../backend/connect_database.php';
    }
    

    public function testUserRegistration()
    {
        $_POST = [
            'submitted' => true,
            'username' => 'testuser',
            'password' => 'TestPassword123',
            'email' => 'testuser@example.com',
            'first-name' => 'Test',
            'last-name' => 'User',
        ];

        
        global $db;
        $db = $this->pdo;
        ob_start(); // Start output buffering at the beginning of the script
        include __DIR__ . '/../backend/register.php';
        ob_end_clean(); // End output buffering and discard the buffer contents
        
        // Verify that the user was added to the database
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute(['testuser']);
        $user = $stmt->fetch();

        $this->assertNotFalse($user, 'User was not registered in the database.');
    }

    protected function tearDown(): void
    {
        // Clean up the database by removing the test user
        $this->pdo->exec("DELETE FROM user WHERE username = 'testuser'");
    }
}
