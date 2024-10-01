<?php

namespace App\Tests\Integration;

use App\Presenter\DataFixtures\UserFixtures;

class AuthTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function loginReturnCredentialsWhenCalled()
    {
        // Arrange
        $client = $this->createClient();

        // Act
        $response = $client->request('POST', '/api/auth/login', [
            'json' => [
                'email' => UserFixtures::USER1_EMAIL,
                'password' => UserFixtures::USER1_PASSWORD,
            ],
        ]);
        // Assert
        $content = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $content);
    }

    /**
     * @test
     */
    public function currentUserReturnNotAuthorizedWhenCredentialsAbsent()
    {
        // Arrange
        $client = $this->createClient();

        // Act
        $client->request('GET', '/api/auth/current');

        // Assert
        $this->assertResponseStatusCodeSame(401);
    }

    /**
     * @test
     */
    public function currentUserReturnUserCalledWithCredentials()
    {
        // Arrange
        $client = $this->createClientWithCredentials();

        // Act
        $response = $client->request('GET', '/api/auth/current');

        // Assert
        $content = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('name', $content);

    }
}
