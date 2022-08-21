<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class accessTest extends TestCase
{
    use WithoutMiddleware;

    private $accessToken = null;

    protected function setUp(): Void
    {
        // 必ずparent::setUp()を呼び出す
        parent::setUp(); 
        $response = $this->json('POST','/api/auth/login', [
            'email' => 'test@test.com',
            'password' => 'test1234'
        ]);
        $response->assertOk();
        $this->accessToken = $response->getOriginalContent()['access_token'];
    }

    public function postWithAuth($url)
    {
        $response = $this->post($url, [
            'Authorization' => 'Bearer '.$this->accessToken
        ]);
        return $response;
    }
    public function getWithAuth($url)
    {
        $response = $this->get($url, [
            'Authorization' => 'Bearer '.$this->accessToken
        ]);
        return $response;
    }

    /**
     * @test
     * @group testing
     */
    public function indexページテスト()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * @test
     * @group testing
     */
    public function Startページテスト()
    {
        $response = $this->getWithAuth('/api/start');
        $response->assertStatus(200);
    }
    /**
     * @test
     * @group testing
     */
    public function scoreページテスト()
    {
        $game_id  = 10;
        $response = $this->withSession(['game_id'=>$game_id])
                        ->postWithAuth('/api/score');

        $response->assertStatus(200);

        $response = $this->withSession(['game_id'=>$game_id])
                        ->getWithAuth('/api/score');

        $response->assertStatus(200);
    }
    /**
     * @test
     * @group testing
     */
    public function playページテスト()
    {
        $response = $this->getWithAuth('/api/play');

        $response->assertStatus(200);
    }
}
