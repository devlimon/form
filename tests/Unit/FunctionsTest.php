<?php

namespace Tests\Unit;

use App\Http\Controllers\FormController;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;

class FunctionsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function symbol_api_is_ok()
    {
        $companies = json_decode(file_get_contents('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json'), true);

        $symbols = array_column($companies, 'Symbol');
    
        $this->assertIsArray($companies);
        $this->assertIsArray($symbols);

    }
}
