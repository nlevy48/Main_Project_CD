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
  // Generate a random number between 1 and 1,000,000
  long randomNumber = random(1, 1000001);

  // Print the random number to the serial monitor
  Serial.println(randomNumber);

  // Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Specify the URL
    http.begin(serverName);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the data to be sent
    String httpRequestData = "randomNumber=" + String(randomNumber);

    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);

    // Print response
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

  // Wait for 1 second before generating the next number
  delay(1000);
}