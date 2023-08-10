


//**********libraries***********
//LCD
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
//RFID-----------------------------
#include <SPI.h>
#include <MFRC522.h>
//NodeMCU--------------------------
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
//************************
#define SS_PIN  D2  //D2
#define RST_PIN D1  //D1
//************************
MFRC522 mfrc522(SS_PIN, RST_PIN); // Create MFRC522 instance.
//************************
/* Set these to your desired credentials. */
const char *ssid = "DESKTOP-1OBGUCT 3540";
const char *password = "123456789";

//************************
String URL = "http://192.168.137.128/Site4/Site3/getdata1.php"; //
String getData, Link;
String OldCardID = "";
unsigned long previousMillis = 0;

LiquidCrystal_I2C lcd(0x27,16,2);
//************************
void setup() {
  delay(1000);
  Serial.begin(115200);
  SPI.begin();  // Init SPI bus
  mfrc522.PCD_Init(); // Init MFRC522 card

   Wire.begin(2,0);
  lcd.init();   // initializing the LCD
  lcd.backlight(); //  Turn On the backlight 
 

  //---------------------------------------------
  connectToWiFi();
}
//************************
void loop() {
  //check if there's a connection to Wi-Fi or not
  if(!WiFi.isConnected()){
    connectToWiFi();    //Retry to connect to Wi-Fi
  }
  //---------------------------------------------
  if (millis() - previousMillis >= 15000) {
    previousMillis = millis();
    OldCardID="";
  }
  delay(50);
  //---------------------------------------------
  //look for new card
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return;//got to start of loop if there is no card present
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;//if read card serial(0) returns 1, the uid struct contians the ID of the read card.
  }
  String CardID ="";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    CardID += mfrc522.uid.uidByte[i];
  }
  //---------------------------------------------
  if( CardID == OldCardID ){
    return;
  }
  else{
    OldCardID = CardID;
  }
  //---------------------------------------------

  SendCardID(CardID);
  delay(1000);
}
//*****send the Card UID to the website****
void SendCardID( String Card_uid ){
  lcd.clear();
  Serial.println("Sending the Card ID");
  if(WiFi.isConnected()){
    HTTPClient http;    //Declare object of class HTTPClient
    //GET Data
    getData = "?card_token=" + String(Card_uid) ; // Add the Card ID to the GET array in order to send it
    //GET methode
    Link = URL + getData;
    WiFiClient wifiClient;  //Object of class HTTPClient
    http.begin(wifiClient, Link);
   
    
    int httpCode = http.GET();   //Send the request
    String payload = http.getString();    //Get the response payload

   Serial.println(Link);   //Print HTTP return code
    Serial.println(httpCode);   //Print HTTP return code
    Serial.println(Card_uid);     //Print Card ID
    Serial.println(payload);    //Print request response payload

    if (httpCode == 200) {
    
      lcd.print(payload); // Start Printing
      delay(100);
      http.end();  //Close connection
    }
  }
}
//*******connect to the WiFi*******
void connectToWiFi(){
    WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
    delay(1000);
    WiFi.mode(WIFI_STA);
    Serial.print("Connecting to ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    
    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
      Serial.print(".");
    }
    Serial.println("");
    Serial.println("Connected");
  
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());  //IP address assigned to the ESP
    
    delay(1000);
}
//=======================================================================