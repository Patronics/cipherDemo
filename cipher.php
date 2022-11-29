<?php $PageTitle="Cipher";?>
<!DOCTYPE html>
<html>
<head>
	<title>Cipher</title>
	<style type="text/css">
	error {color: #FF0000;}
	</style>
</head>
<body>
<!--copyright Paronics 2014-->
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/include.php"; ?>
<div align="center">
<h1> Patronics Cipher</h1>
<?php
// define variables and set to empty values
$crypt_type = $key = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $crypt_type = test_input($_POST["crypt_type"]);
  $key = test_input($_POST["key"]);
  $message = test_input($_POST["message"]);
	if (!(($key>=0)&&($key<=26))&&(!(($crypt_type=='devowelify')||($crypt_type=='underscore')))){
		echo "<font color=red>Please enter a number 0-26 </font>"; 
	}
	elseif ((!(is_numeric($key)))&&(!(($crypt_type=='devowelify')||($crypt_type=='underscore')))){
		echo "<font color=red>Please enter a number 0-26 </font>";
	}
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<input type="radio" name="crypt_type" value="encrypt" 
<?php if (isset($crypt_type) && $crypt_type=="encrypt") echo "checked";?>>Encrypt
<input type="radio" name="crypt_type" value="decrypt"
<?php if (isset($crypt_type) && $crypt_type=="decrypt") echo "checked";?>>Decrypt
<input type="radio" name="crypt_type" value="devowelify"
<?php if (isset($crypt_type) && $crypt_type=="devowelify") echo "checked";?>>Devowelify
<input type="radio" name="crypt_type" value="underscore"
<?php if (isset($crypt_type) && $crypt_type=="underscore") echo "checked";?>>Underscore <br>

key: <input type="number" name="key" min="0" max="26" value=<?php echo $key?>><br>

message to encrypt: <br><textarea name="message" cols="80" rows="10"><?php echo $message;?></textarea><br>

<input type="submit" value="Encrypt!">

</form>

<?php
if (($crypt_type=='decrypt')||($crypt_type=='encrypt'))
{
	$key=(int)$key;	
	if ($crypt_type=='decrypt' ){
		
		$key=-$key;
		//echo "decrypting";
	}
	$translated="";
	$num=0;
	for($i=0;$i<strlen($message);$i++){
	 $msgchar= substr($message, $i, 1);
	 //echo ($msgchar);
	 //echo $message[i];
	 //echo $i;
 	   //print $message[$i];
 	   if (ctype_alpha($msgchar)){
 	   	$num=ord($msgchar);
 	   	
 	   	$num+= $key;
 	   	if (ctype_upper($msgchar)){
 	   		if ($num > ord('Z')){
 	   			$num-=26;
 	   		}
 	   		elseif ($num < ord('A')) {
 	   			$num+=26;
 	   		}
 	   		
 	   	}
 	   	elseif(ctype_lower($msgchar)){
			if ($num > ord('z')){
 	   			$num-=26;
 	   		}
 	   		elseif ($num < ord('a')) {
 	   			$num+=26;
 	   		}
 	   		
 	   	}
 		 $translated.=chr($num);
   	   }
 	   
 	   else{
 	   $translated.=$msgchar;
 	   }
//$translated.=chr($num);
 	}
 	//$translated=substr_replace($translated ,"",-1);
 }
 elseif ($crypt_type=='devowelify')
 {
 	$translated="";
 	$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
 	$translated= str_replace($vowels, "", $message);
 }
 elseif ($crypt_type=='underscore')
 {
 	$translated="";
 	$vowels = str_split($key);
 	$translated= str_replace($vowels, "_", $message);
 }
 	
	?>
encripted message: <br>
<textarea readonly cols="80" rows="10"><?php echo $translated;?></textarea>
<br>
<br>
<a href=http://en.wikipedia.org/wiki/Caesar_cipher>how it works </a>
</div>
</body>
</html>