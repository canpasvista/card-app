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
        $response = $this->json('POST', '/api/auth/login', [
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
        $response = $this->getWithAuth('/api/openboard');
        $response->assertStatus(200);
    }
    /**
     * @test
     * @group testing
     */
    public function scoreページテスト()
    {
        $game_id  = 73;
        $response = $this->getWithAuth('/score?game_id='.$game_id);


        $response->assertStatus(200);
    }
    /**
     * @test
     * @group testing
     */
    public function getscoreページテスト()
    {
        $game_id  = 73;
        $response = $this->withSession( [ 'game_id' => $game_id ])
                        ->getWithAuth('/api/getscore?game_id='.$game_id);


        $response->assertStatus(200);
    }
    /**
     * @test
     * @group testing
     */
    public function getcardページテスト()
    {
        $game_id  = 73;
        $response = $this->getWithAuth('/api/getcard?game_id='.$game_id);


        $response->assertStatus(200);
    }
    /**
     * @test
     * @group testing
     */
    public function getstateページテスト()
    {
        $game_id  = 73;
        $response = $this->getWithAuth('/api/getstate?game_id='.$game_id);


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
