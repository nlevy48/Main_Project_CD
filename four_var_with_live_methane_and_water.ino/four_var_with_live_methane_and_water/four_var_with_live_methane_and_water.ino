#include <WiFi.h>
#include <HTTPClient.h>

// Replace with your network credentials
const char* ssid = "FriendsNet";
const char* password = "ja29jdnasl92882";

// Replace with your server's IP address and PHP script path
const char* serverName = "http://qat-pi-3.friendsbalt.org/get_sensor_data.php";

//Methane Sensor Information

const int AO_Pin = 34; // Connect the AO of MQ-4 sensor with GPIO 34 of ESP32
int methane_sensor; // Create a variable to store the analog output of the MQ-4 sensor
const int DO_Pin = 35; // Connect the DO of Water sensor with GPIO 35 of ESP32
int water_sensor; // Create a variable to store the digital output of the Water sensor
pin
void setup() {
  // Initialize serial communication at 9600 bits per second
  Serial.begin(9600);

  // Connect to Wi-Fi network
  WiFi.begin(ssid, password);

  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }

  Serial.println("Connected to WiFi");

  // Seed the random number generator with an analog input
  randomSeed(analogRead(0));
}

void loop() {
  // Generate random numbers for the sensors
 
  long turbidity_sensor = random(1, 1000001);
  long temperature_sensor = random(1, 1000001);
  methane_sensor = analogRead(AO_Pin); // Read the analog output measurement sample from the MQ4 sensor's AO pin
  water_sensor = digitalRead(DO_Pin); // Read the digital output measurement sample from the Water sensor's DO pin
  Serial.print("Water Level Sensor: ");
  Serial.println(water_sensor); // Print out the water level value - the digital output - between 0 and 1
  Serial.print("Methane Conentration: "); // Print out the text "Methane Concentration: "
  Serial.println(methane_sensor); // Print out the methane value - the analog output - beteewn 0 and 1023

  // Print the sensor values to the serial monitor
  Serial.print("Methane Conentration: "); // Print out the text "Methane Concentration: "
  Serial.println(methane_sensor); // Print out the methane value - the analog output - between 0 and 1023
  Serial.print("Water Level Sensor: ");
  Serial.println(water_sensor);
  Serial.print("Turbidity Sensor: ");
  Serial.println(turbidity_sensor);
  Serial.print("Temperature Sensor: ");
  Serial.println(temperature_sensor);

  // Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Specify the URL
    http.begin(serverName);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the data to be sent
    String httpRequestData = "methane_sensor=" + String(methane_sensor) +
                             "&water_level_sensor=" + String(water_sensor) +
                             "&turbidity_sensor=" + String(turbidity_sensor) +
                             "&temperature_sensor=" + String(temperature_sensor);

    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);

    // Print response to the serial monitor
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(httpResponseCode);
      Serial.println(response);
    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
    }

    // End the HTTP connection
    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }

  // Wait for 10 seconds before sending the next request
  delay(1000);
}