<?php

namespace App\Http\Controllers;
use App\Http\Controllers\MQTTController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;
use App\Models\datadht;
use App\Models\ledstatus;
use App\Models\fanstatus;
session_start();
class HomeController extends Controller
{
    public function index()
    {
        $ledstatus = new ledstatus();
        $ledstatus = ledstatus::where('id', ledstatus::max('id'))->first();
        $fanstatus = new fanstatus();
        $fanstatus = fanstatus::where('id', fanstatus::max('id'))->first();
        session()->put('led' , $ledstatus->status);
        session()->put('fan' , $fanstatus->status);
        $ledStatusOn = ledstatus::where('status', '1')->count(); 
        $ledStatusOff = ledstatus::where('status', '0')->count(); 
        $fanStatusOn = fanstatus::where('status', '1')->count();
        $fanStatusOff = fanstatus::where('status', '0')->count();
        $dataView = [
            'ledStatusOn' => $ledStatusOn,
            'ledStatusOff' => $ledStatusOff,
            'fanStatusOn' => $fanStatusOn,
            'fanStatusOff' => $fanStatusOff
        ];
        return view('pages.home', $dataView);
    }
    public function history()
    {
        return view('pages.history');
    }
    public function information()
    {
        return view('pages.information');
    }
}