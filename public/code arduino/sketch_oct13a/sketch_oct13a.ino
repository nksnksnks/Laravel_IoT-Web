//mosquitto_sub -h broker.mqtt-dashboard.com -t data
//mosquitto_pub -h broker.mqtt-dashboard.com -t led_onoff -m "1"
//mosquitto_pub -h broker.mqtt-dashboard.com -t fan_onoff -m "1"
//mosquitto_sub -h localhost -t data
#include <ESP8266WiFi.h>
#include "DHTesp.h"
#include <ArduinoJson.h>
#include <PubSubClient.h>
#include <WiFiClientSecure.h>

#define DHTpin 2  
#define VIN 3.3
#define R 10000
DHTesp dht;
const int quangTro = A0;

const int led = 4; 
const int fan = 5;

const char* ssid = "Denho";
const char* password = "denhohon";
const char* mqtt_server = "broker.mqtt-dashboard.com";
const char* mqtt_username = "nksnks";
const char* mqtt_password = "0123456789";
const int mqtt_port = 8883;

/**** Secure WiFi Connectivity Initialisation *****/
WiFiClientSecure espClient;

/**** MQTT Client Initialisation Using WiFi Connection *****/
PubSubClient client(espClient);

unsigned long lastMsg = 0;
#define MSG_BUFFER_SIZE (50)
char msg[MSG_BUFFER_SIZE];

void setup_wifi() {
  delay(10);
  Serial.print("\nConnecting to ");
  Serial.println(ssid);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }

  randomSeed(micros());
  Serial.println("\nWiFi connected\nIP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    String clientId = "ESP8266Client-3039";   // Create a random client ID
    // clientId += String(random(0xffff), HEX);

    // Attempt to connect
    if (client.connect(clientId.c_str(), mqtt_username, mqtt_password)) {
      Serial.println("connected");
      client.subscribe("led_onoff");   // subscribe the topics here
      client.subscribe("fan_onoff");
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");   // Wait 5 seconds before retrying
      delay(10000);
    }
  }
}

void callback(char* topic, byte* payload, unsigned int length) {
  String incommingMessage = "";
  for (int i = 0; i < length; i++) incommingMessage += (char)payload[i];
  Serial.println("Message arrived [" + String(topic) + "]" + incommingMessage);

  //--- check the incomming message
  if(strcmp(topic, "led_onoff") == 0){
     if (incommingMessage.equals("1")) digitalWrite(led, HIGH);   // Turn on led
     else digitalWrite(led, LOW);  // Turn off led
  }
  
  if(strcmp(topic, "fan_onoff") == 0){
    if(incommingMessage.equals("1")) digitalWrite(fan, HIGH);
    else digitalWrite(fan, LOW);
  }
}

void publishMessage(const char* topic, String payload , boolean retained){
  if (client.publish(topic, payload.c_str(), true))
    Serial.println("Message publised [" + String(topic)+"]: " + payload);
}

void setup() {
  dht.setup(DHTpin, DHTesp::DHT11); //Set up DHT11 sensor
  pinMode(led, OUTPUT);
  pinMode(fan, OUTPUT); 
  Serial.begin(9600);
  while (!Serial) delay(1);
  setup_wifi();

  espClient.setInsecure();
  client.setServer(mqtt_server, mqtt_port);
  client.setCallback(callback);
}
void loop() {
  if (!client.connected()) reconnect(); // check if client is connected
  client.loop();
  
  //read DHT11 temperature and humidity reading
  delay(dht.getMinimumSamplingPeriod());
  float doAm = dht.getHumidity();
  float nhietDo = dht.getTemperature();
  int anhSang = analogRead(quangTro);

  DynamicJsonDocument doc(1024);
  doc["doAm"] = doAm;
  doc["nhietDo"] = nhietDo;
  doc["anhSang"] = anhSang;

  char mqtt_message[128];
  serializeJson(doc, mqtt_message);
  publishMessage("data", mqtt_message, true);
  delay(2000);
}