#include <WiFi.h>
#include <HTTPClient.h>

// Replace with your network credentials
const char* ssid = "FriendsNet";
const char* password = "ja29jdnasl92882";

// Replace with your server's IP address and PHP script path
const char* serverName = "http://qat-pi-3.friendsbalt.org/get_random_number_data.php";

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
  long methane_sensor = random(1, 1000001);
  long water_level_sensor = random(1, 1000001);
  long turbidity_sensor = random(1, 1000001);
  long temperature_sensor = random(1, 1000001);

  // Print the sensor values to the serial monitor
  Serial.print("Methane Sensor: ");
  Serial.println(methane_sensor);
  Serial.print("Water Level Sensor: ");
  Serial.println(water_level_sensor);
  Serial.print("Turbidity Sensor: ");
  Serial.println(turbidity_sensor);
  serial.print("Temperature Sensor: ");
  serial.println(temperature_sensor);

  // Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Specify the URL
    http.begin(serverName);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the data to be sent
    String httpRequestData = "methane_sensor=" + String(methane_sensor) +
                             "&water_level_sensor=" + String(water_level_sensor) +
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
  delay(10000);
}