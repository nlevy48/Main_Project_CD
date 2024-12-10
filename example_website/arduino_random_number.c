void setup() {
  // Initialize serial communication at 9600 bits per second
  Serial.begin(9600);

  // Seed the random number generator with an analog input
  // This helps to ensure that the random numbers are more random
  randomSeed(analogRead(0));
}

void loop() {
  // Generate a random number between 1 and 1,000,000
  long randomNumber = random(1, 1000001);

  // Print the random number to the serial monitor
  Serial.println(randomNumber);

  // Wait for 1 second before generating the next number
  delay(1000);