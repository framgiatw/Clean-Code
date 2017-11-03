<?php

/**Dinh Van Tai*/

/**
    * 1. Substitute Algorithm
*/
function foundPerson(array $people)
{
    for ($i = 0; $i < count($people); $i++) {
        if ($people[$i] == 'Don') {
            return 'Don';
        }
        if ($people[$i] == 'John') {
            return 'John';
        }
        if ($people[$i] =='Kent') {
            return 'Kent';
        }
    }

    return '';
}

// Refactor
function foundPerson(array $people)
{
    foreach (['Don', 'John', 'Kent'] as $needle) {
        if (in_array($needle, $people) {
            return $needle;
        }
    }

    return '';
}

/**
    * 2.Replace Nested Conditional with Guard Clauses
*/
public function getPayAmount() {
    if ($this->isDead) {
        $result = $this->deadAmount();
    } elseif ($this->isSeparated) {
        $result = $this->separatedAmount();
    } elseif ($this->isRetired) {
        $result = $this->retiredAmount();
    } else {
        $result = $this->normalPayAmount();
    }

    return $result;
}

// Refactor
public function getPayAmount() {
    if ($this->isDead) {
        return $this->deadAmount();
    }
    if ($this->isSeparated) {
        return $this->separatedAmount();
    }
    if ($this->isRetired) {
        return $this->retiredAmount();
    }

    return $this->normalPayAmount();
}

/**
    * 3. Replace Conditional with Polymorphism
*/
class Bird
{
    public function getSpeed() {
        switch ($this->type) {
            case 'EUROPEAN':
                return $this->getBaseSpeed();
            case 'AFRICAN':
                return $this->getBaseSpeed() - $this->getLoadFactor() * $this->numberOfCoconuts;
            case 'NORWEGIAN_BLUE':
                return ($this->isNailed) ? 0 : $this->getBaseSpeed($this->voltage);
        }
        throw new Exception('Should be unreachable');
    }
}

// Refactor
abstract class Bird
{
    abstract public function getSpeed();
}

class European extends Bird
{
    public function getSpeed()
    {
        return $this->getBaseSpeed();
    }
}
class African extends Bird
{
    function getSpeed()
    {
        return $this->getBaseSpeed() - $this->getLoadFactor() * $this->numberOfCoconuts;
    }
}
class NorwegianBlue extends Bird
{
    function getSpeed()
    {
        return ($this->isNailed) ? 0 : $this->getBaseSpeed($this->voltage);
    }
}


/**Vu Xuan Truong*/

/**
    * 4. Long Method
*/

function printPerfectBoy() {

    //print menu
    print("************************");
    print("********* Menu *********");
    print("************************");

    // Perfect Boy = Gender(Boy) + mathPerfect + englishPerfect ;
    if ($this->gender == 1 && $this->getMathScore() > 8 && $this->getEnglishScore > 8) {
        //print details
        print("Student name:  " . $this->name);
        print("Student math score : " . this->getMathScore());
        print("Student english score : " . this->getEnglishScore());
    }
}

// Refactor (Extract Method):

function printPerfectBoy() {
    $this->printMenu();

    // Perfect Boy = Gender(Boy) + mathPerfect + englishPerfect ;
    if ($this->isBoy() && $this->getMathScore() > 8 && $this->getEnglishScore > 8) {
        $this->printDetails();
    }
}

function isBoy() {
    return $this->getGender == 1;
}
function printMenu() {
    print("************************");
    print("********* Menu *********");
    print("************************");
}
function printDetails () {
    print("Student name:  " . $this->name);
    print("Student math score : " . this->getMathScore());
    print("Student english score : " . this->getEnglishScore());
}

/**
    * 5. Comment
*/

function printPerfectBoy() {
    $this->printMenu();

    // Perfect Boy = Gender(Boy) + mathPerfect + englishPerfect ;
    if ($this->isBoy() && $this->getMathScore() > 8 && $this->getEnglishScore > 8) {
        $this->printDetails();
    }
}

// Refactor (Extract Variable) :

function printBestBoy() {
    $this->printMenu();

    $isBoy = $this->gender == 1;
    $isMathPerfect = $this->getMathScore() > 8;
    $isEnglishPerfect = $this->getEnglishScore() > 8;
    if ($isBoy && $isMathPerfect && $isEnglishPerfect) {
        $this->printDetails($this->getScore());
    }
}


/**
    * 6. Primitive Obsession
*/

function printBestBoy() {
    $this->printMenu();

    $isBoy = $this->gender == 1;
    $isMathPerfect = $this->getMathScore() > 8;
    $isEnglishPerfect = $this->getEnglishScore() > 8;
    if ($isBoy && $isMathPerfect && $isEnglishPerfect) {
        $this->printDetails($this->getScore());
    }
}

//Refactor (Replace Data Value with Object):

class ScoreType {
    const PERFECT = 8;
    function getPerfect() {
        return PERFECT;
    }
}
class Student {
    const BOY = 1;
    function isBoy() {
        return $this->getGender == BOY;
    }
    function printBestBoy() {
        $this->printMenu();

        $scoreType = new ScoreType();
        $isMathPerfect = $this->getMathScore() > $scoreType->getPerfect();
        $isEnglishPerfect = $this->getEnglishScore > $scoreType->getPerfect();
        if ($this->isBoy() && $isMathPerfect && $isEnglishPerfect) {
            $this->printDetails($this->getScore());
        }
    }
}


/* Ngo Trung Thang */

/**
    * 7. Long Parameter List
*/
function showInfo($height, $weight, $gender, $class, $address)
{
    echo $height;
    echo $weight;
    echo $gender;
    echo $class;
    echo $address;
}

//refactor
function showInfo($data)
{
    echo $data['height'];
    echo $data['weight'];
    echo $data['gender'];
    echo $data['class'];
    echo $data['address'];
}

/**
    * 8. Long Method
*/
class Order
{
    public function calculate()
    {
        $details = $this->getOrderDetails();
        foreach ($details as $detail) {
            if (!$detail->hasVat()) {
                $vat = $this->getCustomer()->getVat();
            } else {
                $vat = $detail->getVat();
            }
            $price = $detail->getAmount() * $detail->getPrice();
            $total += $price + ($price / 100 * $vat->getValue());
        }
        if ($this->hasDiscount()) {
            $total = $total–($total / 100 * $this->getDiscount());
        } elseif ($this->getCustomer()->hasDiscountForMaxAmount() && $total >= $this->getCustomer()->getMaxAmountForDiscount()) {
            $total = $total–($total / 100 * $this->getCustomer()->getDiscountForMaxAmount());
        }

        return $total;
    }
}

//refactor
class Order
{
    private function calculateDetailsPrice()
    {
        foreach ($this->getOrderDetails() as $detail) {
            if (!$detail->hasVat()) {
                $vat = $this->getCustomer()->getVat();
            } else {
                $vat = $detail->getVat();
            }
            $price = $detail->getAmount() * $detail->getPrice();
            $total += $price + ($price/100 * $vat->getValue());
        }

        return $total;
    }

    private function applyDiscount($total)
    {
        if ($this->hasDiscount()) {
            $total = $total - ($total/100 * $this->getDiscount());
        } elseif ($this->getCustomer()->hasDiscountForMaxAmount() &&
            $total >= $this->getCustomer()->getMaxAmountForDiscount()) {
            $total = $total - ($total/100 * $this->getCustomer()->getDiscountForMaxAmount());
        }

        return $total;
    }
    public function calculate()
    {
        return $this->applyDiscount($this->calculateDetailsPrice());
    }
}

/**
    * 9. Duplicate Code
*/

class Customer extends Person
{
    public function getAge()
    {
        return date('Y') - date('Y', strtotime("2010-12-17"));
    }
}

class Vendor extends Person
{
    public function getAge()
    {
        return date('Y') - date('Y', strtotime("2010-12-17"));
    }
}

//refactor
class Person
{
    public function getAge()
    {
        return date('Y') - date('Y', strtotime("2000-11-25"));
    }
}

class Customer extends Person
{
//
}

class Vendor extends Person
{
//
}

/** Pham Viet Toan */

/**
 * 10. Data clump
 */
$name = $person->getName();
$age = $person->getAge();
$getPerson = $persons->find($name, $age);

//refactor
$getPerson = $person->find($person);

/**
 * 11. Temporary field -replace method with method object
 */

class Order {
    public function sendMail() {
        $name = 'Pham Viet Toan';
        $email = 'viettoan290696@gmail.com';
        $age = 22;
        $price = 100;
        // long computation.
    }
}

//refactor
class Order {
    public function sendMail() {
        return new Mail($this)->send();
    }
}

class Mail {
    private $name;
    private $email;
    private $age;
    private $price;

    public __construct(Order $order) {
        // copy relevant information from order object.
    }

    public function send() {
        // long computation.
    }
}

/**
 * 12. Refused bequest - extract superclass
 */

class Department {

    public function getCount() {}

    public function getName() {}

    public function getPlace() {}
}

class Employee {
    public function getName() {}

    public function getId() {}
}

 //refactor

class Party {
    public function getName() {}
}

class Department extends Party {
    public function getCount() {}

    public function getPlace() {}
}

class Employee extends Party {
    public function getId() {}
}
