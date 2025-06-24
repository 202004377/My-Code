#include <Servo.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

// Initialize LCD with I2C address 0x27, 20 columns and 4 rows
LiquidCrystal_I2C lcd(0x27, 20, 4);

Servo myservo;

// IR sensor pins
#define ir_enter 2
#define ir_back  4
#define ir_car1  5
#define ir_car2  6
#define ir_car3  7
#define ir_car4  8

// Sensor states and flags
int s1 = 0, s2 = 0, s3 = 0, s4 = 0;
int flag1 = 0, flag2 = 0;  // Fixed missing comma
int totalSlots = 4;
int availableSlots = 4;

void setup() {
  Serial.begin(9600);

  // Set pin modes
  pinMode(ir_car1, INPUT);
  pinMode(ir_car2, INPUT);
  pinMode(ir_car3, INPUT);
  pinMode(ir_car4, INPUT);
  pinMode(ir_enter, INPUT);
  pinMode(ir_back, INPUT);

  // Servo initialization
  myservo.attach(3);
  myservo.write(90);  // Initial position (closed)

  // LCD initialization
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 1);
  lcd.print("   Car Parking   ");
  lcd.setCursor(0, 2);
  lcd.print("     System      ");
  delay(2000);
  lcd.clear();

  // Initial sensor reading
  updateSensorStates();
  updateSlotCount();
}

void loop() {
  updateSensorStates();
  updateSlotCount();
  
  displayStatus();
  
  handleEntry();
  handleExit();
  
  delay(100);  // Small delay to reduce CPU usage
}

void updateSensorStates() {
  s1 = !digitalRead(ir_car1);  // Inverted logic if IR sensors are active-low
  s2 = !digitalRead(ir_car2);
  s3 = !digitalRead(ir_car3);
  s4 = !digitalRead(ir_car4);
}

void updateSlotCount() {
  int occupiedSlots = s1 + s2 + s3 + s4;
  availableSlots = totalSlots - occupiedSlots;
}

void displayStatus() {
  lcd.clear();
  
  // Display available slots
  lcd.setCursor(0, 0);
  lcd.print("Available: ");
  lcd.print(availableSlots);
  lcd.print("/");
  lcd.print(totalSlots);
  
  // Display slot status
  lcd.setCursor(0, 1);
  lcd.print("S1:");
  lcd.print(s1 ? "Full " : "Empty");
  
  lcd.setCursor(10, 1);
  lcd.print("S2:");
  lcd.print(s2 ? "Full " : "Empty");
  
  lcd.setCursor(0, 2);
  lcd.print("S3:");
  lcd.print(s3 ? "Full " : "Empty");
  
  lcd.setCursor(10, 2);
  lcd.print("S4:");
  lcd.print(s4 ? "Full " : "Empty");
}

void handleEntry() {
  if (!digitalRead(ir_enter) && flag1 == 0) {
    if (availableSlots > 0) {
      flag1 = 1;
      myservo.write(180);  // Open gate
      lcd.setCursor(0, 3);
      lcd.print(" Welcome! Entering ");
      delay(2000);
    } else {
      lcd.setCursor(0, 3);
      lcd.print("  Parking Full!   ");
      delay(1500);
    }
  }
}

void handleExit() {
  if (!digitalRead(ir_back) && flag2 == 0) {
    flag2 = 1;
    myservo.write(180);  // Open gate
    lcd.setCursor(0, 3);
    lcd.print("  Thank You! Exiting ");
    delay(2000);
  }

  // Reset gate if both flags are set
  if (flag1 == 1 && flag2 == 1) {
    delay(1000);
    myservo.write(90);  // Close gate
    flag1 = 0;
    flag2 = 0;
    lcd.setCursor(0, 3);
    lcd.print("                    ");
  }
}
