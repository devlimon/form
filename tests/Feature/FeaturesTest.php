<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturesTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function index_page_is_ok(): void
    {
        $response = $this->get('/');

        $response->assertSee('Submit Form');
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function form_submission_is_ok()
    {
        $response = $this->post('/form', [
            'company_symbol' => 'AAPL',
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
            'email' => 'altafhossainlimon@gmail.com',
        ]);
    
        $response->assertStatus(200);
        $response->assertViewIs('data');

    }

    public function rapid_api_call_is_fetching_data()
    {
        $client = new \GuzzleHttp\Client();

        $url = 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';
        $params = [
            'symbol' => 'AAPL',
            'region' => 'US'
        ];

        $headers = [
            'X-RapidAPI-Key' => config('services.rapid_api_key', 'cf36fa5052msh238c995cb505fcap18b119jsn66af7e94c7c8'),
            'X-RapidAPI-Host' => 'yh-finance.p.rapidapi.com',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $response = $client->get($url, [
            'query' => $params,
            'headers' => $headers
        ]);

        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody, true);

        $this->assertArrayHasKey('prices', $data);
        $this->assertIsArray($data['prices']);
    }




}
