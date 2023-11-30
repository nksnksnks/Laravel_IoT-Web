<?php

namespace App\Http\Controllers;
use Bluerhinos\phpMQTT;
use Illuminate\Http\Request;
use App\Models\SensorData;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;
use PhpMqtt\Client\Facades\MQTT;
use App\Models\datadht;
use App\Models\ledstatus;
use App\Models\fanstatus;
session_start();
class MqttController extends Controller
{
    public function sendMqttCommand()
    {
        $mqttBroker = 'broker.mqtt-dashboard.com';
        $mqttTopic = 'led_onoff';
        $mqttMessage = '1';
        $ledstatus = new ledstatus();
        $ledstatus->status = 1;
        $currentTime = new \DateTime();
        $ledstatus->time = $currentTime->format('H:i:s');
        $currentDate = $currentTime->format('Y-m-d');
        $ledstatus->day = $currentDate;
        $ledstatus->save();
        // Tạo lệnh để gửi qua mosquitto_pub
        $command = "mosquitto_pub -h $mqttBroker -t $mqttTopic -m \"$mqttMessage\"";
        // Thực thi lệnh
        exec($command, $output, $returnVar);
        $ledStatusOn = ledstatus::where('status', '1')->count(); 
        // Kiểm tra kết quả
        if ($returnVar === 0) {
            return response()->json(['ledStatusOn' => $ledStatusOn]);
        } else {
            return response()->json(['message' => 'Có lỗi xảy ra khi gửi câu lệnh MQTT.']);
        }
    }
    public function sendMqttCommandoff()
    {
        $mqttBroker = 'broker.mqtt-dashboard.com';
        $mqttTopic = 'led_onoff';
        $mqttMessage = '0';
        $ledstatus = new ledstatus();
        $ledstatus-> status = 0;
        $currentTime = new \DateTime();
        $ledstatus->time = $currentTime->format('H:i:s');
        $currentDate = $currentTime->format('Y-m-d');
        $ledstatus->day = $currentDate;
        $ledstatus->save();
        // Tạo lệnh để gửi qua mosquitto_pub
        $command = "mosquitto_pub -h $mqttBroker -t $mqttTopic -m \"$mqttMessage\"";

        // Thực thi lệnh
        exec($command, $output, $returnVar);
        // Kiểm tra kết quả
        if ($returnVar === 0) {
            return response()->json(['message' => 'Gửi thành công']);
        } else {
            return response()->json(['message' => 'Có lỗi xảy ra khi gửi câu lệnh MQTT.']);
        }
    }
    public function sendMqttCommand2()
    {
        $mqttBroker = 'broker.mqtt-dashboard.com';
        $mqttTopic = 'fan_onoff';
        $mqttMessage = '1';
        $fanstatus = new fanstatus();
        $fanstatus-> status = 1;
        $currentTime = new \DateTime();
        $fanstatus->time = $currentTime->format('H:i:s');
        $currentDate = $currentTime->format('Y-m-d');
        $fanstatus->day = $currentDate;
        $fanstatus->save();
        // Tạo lệnh để gửi qua mosquitto_pub
        $command = "mosquitto_pub -h $mqttBroker -t $mqttTopic -m \"$mqttMessage\"";

        // Thực thi lệnh
        exec($command, $output, $returnVar);

        // Kiểm tra kết quả
        if ($returnVar === 0) {
            return response()->json(['message' => 'Câu lệnh MQTT đã được gửi thành công.']);
        } else {
            return response()->json(['message' => 'Có lỗi xảy ra khi gửi câu lệnh MQTT.']);
        }
    }
    public function sendMqttCommandoff2()
    {
        $mqttBroker = 'broker.mqtt-dashboard.com';
        $mqttTopic = 'fan_onoff';
        $mqttMessage = '0';

        // Tạo lệnh để gửi qua mosquitto_pub
        $command = "mosquitto_pub -h $mqttBroker -t $mqttTopic -m \"$mqttMessage\"";

        // Thực thi lệnh
        exec($command, $output, $returnVar);
        $fanstatus = new fanstatus();
        $fanstatus-> status = 0;
        $currentTime = new \DateTime();
        $fanstatus->time = $currentTime->format('H:i:s');
        $currentDate = $currentTime->format('Y-m-d');
        $fanstatus->day = $currentDate;
        $fanstatus->save();
        // Kiểm tra kết quả
        if ($returnVar === 0) {
            return response()->json(['message' => 'Câu lệnh MQTT đã được gửi thành công.']);
        } else {
            return response()->json(['message' => 'Có lỗi xảy ra khi gửi câu lệnh MQTT.']);
        }
    }
    public function subscribe()
    {
        $mqttBroker = 'broker.mqtt-dashboard.com';

        $command = "mosquitto_sub -h $mqttBroker -t data -C 1";
        $output = exec($command, $result);

        $mqttData = json_decode($output, true); 

        $datadht = new datadht();
        $datadht->temperature = $mqttData['nhietDo'];
        $datadht->humidity = $mqttData['doAm'];
        $datadht->light = $mqttData['anhSang'];
        $currentTime = new \DateTime();
        $datadht->time = $currentTime->format('H:i:s');
        $currentDate = $currentTime->format('Y-m-d');
        $datadht->day = $currentDate;
        $datadht->save();
        return response()->json([
            'temperature' => $mqttData['nhietDo'],
            'humidity' => $mqttData['doAm'], 
            'light' => $mqttData['anhSang'],
        ]);
    }
    public function onOffTimes(){
        $ledStatusOn = ledstatus::where('status', '1')->count(); 
        $ledStatusOff = ledstatus::where('status', '0')->count(); 
        $fanStatusOn = fanstatus::where('status', '1')->count();
        $fanStatusOff = fanstatus::where('status', '0')->count();

        return response()->json([
            'ledStatusOn' => $ledStatusOn,
            'ledStatusOff' => $ledStatusOff,
            'fanStatusOn' => $fanStatusOn,
            'fanStatusOff' => $fanStatusOff,
        ]);
    }
}   