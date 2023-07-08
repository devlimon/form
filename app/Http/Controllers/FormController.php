<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckFormData;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyUser;

class FormController extends Controller
{
    public function index(){
        return view('welcome');
    }


    public function checkForm(CheckFormData $request){

        $client = new Client();

        $url = 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';
        $params = [
            'symbol' => strtoupper($request->company_symbol),
            'region' => 'US'
        ];

        $headers = [
            'X-RapidAPI-Key' =>config('services.rapid_api_key','cf36fa5052msh238c995cb505fcap18b119jsn66af7e94c7c8'),
            'X-RapidAPI-Host' =>'yh-finance.p.rapidapi.com',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $response = $client->get($url, [
            'query' => $params,
            'headers' => $headers
        ]);

        $responseBody = $response->getBody()->getContents();

        $data = collect(json_decode($responseBody,true)['prices']);


        $chartLables=[];
        $chartHighData=[];
        $chartLowData=[];

        $start_date=$request->start_date;
        $end_date=$request->end_date;

        $dataInRages=$data->where('date','>=',strtotime($request->start_date))->where('date','<=',strtotime($request->end_date));


        $companies=collect(json_decode(file_get_contents('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json')));
        $company_name=$companies->where('Symbol',$request->company_symbol)->first()->{'Company Name'};

        $mailData=['start_date'=>$start_date,'end_date'=>$end_date,'company_name'=>$company_name];

        Mail::to($request->email)->send(new NotifyUser($mailData));

        return view('data',compact('data','dataInRages','start_date','end_date','chartLables','chartHighData','chartLowData'));

    }

  



}
