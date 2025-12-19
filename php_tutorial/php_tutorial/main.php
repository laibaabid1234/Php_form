<?php 
// print "hello world";
echo "??????","jgtggvhg";

$a=10;
$b=10;
$c=5;
echo $a + $b;
$name="laiba";
$bol=true;
$age=20;
$contact="615365433";
var_dump($contact);

if(($a==$b && $a==$c) || $b==$c)
{
    echo "helooooooo";
}else if($a==$b || $b==$c){
    echo "one wrong.......";
}else{
 echo "one wrong.......";
}
function myMessage() {
  echo "Hello world!";
}
myMessage();

function familyName($fname,$lname=null) {
  echo "$fname $lname.<br>";
}

familyName(1,1,'');
familyName("Hege");
familyName("Stale");
familyName("Kai Jim");
familyName("Borge");


function calculator($a,$b,$opr)
{
    if($opr=="+"){
        $c=$a+$b;
        echo "answer of your given operator is $c \n";
    }else if($opr=="-"){
        $c=$a-$b;
        echo "answer of your given operator is $c \n";
    }else if($opr=="*"){
         $c=$a*$b;
         echo "answer of your given operator is $c \n";
    }
    else if($opr=="/"){
        $c=$a/$b;
        echo "answer of your given operator is $c \n";
    }else{
        echo "please select a valid operator to perform any arthimatic opertaion..";
    }
   
    
}


calculator(10,20,"+");
calculator(40,20,"/");
calculator(10,20,"*");
calculator(40,20,"-");
// calculator(10,20,"$");

# Keep asking user for a number until they type 0


?>

<?php
// List of product prices
$prices = [500, 1200, 750, 300, 1500];

$total = 0;

// Loop through products and add to total
// for ($i = 0; $i < count($prices); $i++) {
//     echo "Product " . ($i+1) . " price: " . $prices[$i] . " PKR<br>";
//     $total += $prices[$i];
// }

// echo "<b>Total Bill: $total PKR</b>";


for($i=0; $i < count($prices); $i++ ){
    echo "Product " . ($i+1) . " price: " . $prices[$i] . " PKR<br>";
   $total +=$prices[$i];
}
echo "<b>Total Bill: $total PKR</b>";
?>
<?php
$correctPin = 1234;
$attempts = 0;

while (true) {
    $input = readline("Enter your ATM PIN: ");
    $attempts++;

    if ($input == $correctPin) {
        echo "✅ Access Granted. Welcome!\n";
        break;
    } else {
        echo "❌ Incorrect PIN. Try again.\n";
    }

    // Agar 3 bar galat kare to block kar do
    if ($attempts >= 3) {
        echo "🚫 Card Blocked! Too many wrong attempts.\n";
        break;
    }
}


$i=2;
while($i<5){
    echo "<br>jhdjahdjash";
    $i++;
}


?>

<?php
$x = 5;

do {
    echo "<br>Value of x: $x\n";
    $x++;
} 
while ($x < 5);
?>

<?php
$cart = [
    "Burger" => 250,
    "Pizza" => 800,
    "Fries" => 150
];

$total = 0;

foreach ($cart as $item => $price) {
    echo "$item : $price PKR<br>";
    $total += $price;
}

echo "<b>Total Bill: $total PKR</b><br>";

//outer loop for rows//
for($i=1;$i<=5;$i++)
{
    //inner loop for columns
    for($j=5;$j>=$i;$j--){
        echo "*";
    }
    echo "<br>";
}

// for($i=1;$i<=5;$i++)
// {
//     //inner loop for columns
//     for($j=1;$j<=$i;$j++){
//         echo "*";
//     }
//     echo "<br>";
// }


?>
<?php
$space="&nbsp;";
for ($i = 1; $i <= 5; $i++) {
    for ($s = 1; $s <= 5 - $i; $s++) {
        echo "&nbsp;&nbsp;"; 
    }
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }

    echo "<br>";
}
?>
<?php  

// function myFunction() {
//   echo "This text comes from a function";
// }


$myArr = array("Volvo", 15, "hghgf","gfhg","drdd","fdfdfdfdfd","hff","hghgf","gff");
array_push($myArr,"laiba");
$d=$myArr[0];
$myArr[0]=$myArr[2];
$myArr[2]=$d;


// calling the function from the array item:
// echo $myArr[0];
for($i=0;$i < count($myArr); $i++){
   
 echo "Sr No.". $i+1 .")  ".$myArr[$i]."<br>";
}

$arr=["hd","jds","sakl",["lkda","jd","jsd"],"sjd",["sa","sa",["cghg","shsha","hsgd"],"htf","gtr"]]
?>  
<?php
$cars = array (
  array("Volvo",22,18),
  array("BMW",15,13,15,19,["ds","das","ds"]),
  array("Saab",5,2,3),
  array("Land Rover",17,15)
);
    
for ($row = 0; $row < count($cars); $row++) {
  echo "<p><b>Row number " . ($row + 1) . "</b></p>";
  echo "<ul>";
  
  for ($col = 0; $col < count($cars[$row]); $col++) {
    echo "<li>".$cars[$row][$col];
    
    if(is_array($cars[$row][$col])) {
        echo "<ul>";
        for($i = 0; $i < count($cars[$row][$col]); $i++) {
            echo "<li>".$cars[$row][$col][$i]."</li>";
        }
        echo "</ul>";
    }
    
    echo "</li>";
  }
  echo "</ul>";
}


$cars = array (
  array("Volvo",22,18),
  array("BMW",15,13,15,19,["ds","das","ds"]),
  array("Saab",5,2,3),
  array("Land Rover",17,15)
);
    
for ($row = 0; $row < count($cars); $row++) {
  echo "<p><b>Row number " . ($row + 1) . "</b></p>";
  echo "<ul>";
  
  for ($col = 0; $col < count($cars[$row]); $col++) {
    if (is_array($cars[$row][$col])) {
        echo "<li>Sub Array:";
        echo "<ul>";
        for ($i = 0; $i < count($cars[$row][$col]); $i++) {
            echo "<li>".$cars[$row][$col][$i]."</li>";
        }
        echo "</ul>";
        echo "</li>";
    } else {
        echo "<li>".$cars[$row][$col]."</li>";
    }
  }
  echo "</ul>";
}

?>


