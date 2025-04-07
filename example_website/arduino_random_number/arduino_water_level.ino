int liquid_level = 0;
void setup() {
Serial.begin(9600);
pinMode(5,INPUT);
}

void loop() {
liquid_level = digitalRead(5);
Serial.print("Liquid_level= ");Serial.println(liquid_level,DEC);
delay(500);
}
