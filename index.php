<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>

		div.container {
    		background-color: white;
    		width: auto;
		height: auto;
    		padding: 30px;
    		border: 2px solid #ff8000;
		margin: 20px;
}
		div.content {
		float:right;
		border-radius:10px;
		border:2px solid #ff8000;
		padding:20px;
		width:300px;
		height:450px;
}

		div.box1 {
		border-radius:10px;
		border:2px solid #ff8000;
		padding:20px;
		width:400px;
		height:300px;
		
}
		div.box2 {
		border-radius:10px;
		border:2px solid #ff8000;
		padding:20px;
		width:400px;
		height:95px;
		
}
		div.box3 {
		border-radius:10px;
		border:2px solid #2004ef;
		padding:20px;
		width:600px;
		height:auto;
		margin-left: auto;
		margin-right: auto;
		
}
		h1 {
		font-size=14;
		text-align: center;
		color: #2004ef;
}
		hr { 
    		display: block;
    		margin-top: 0.5em;
    		margin-bottom: 0.5em;
    		margin-left: auto;
    		margin-right: auto;
    		border-style: inset;
    		border-width: 1px;
		color: #2004ef;
}

</style>
<title>Forensic Exemplars</title>
<!----link href="style.css" rel="stylesheet" type="text/css" /--->
  <script type="text/javascript">
    function select()
    {
     var1=document.getElementById("radio1");
     var2=document.getElementById("radio2");
     if(var1.checked==true)
     {
        document.myform.action="<?php echo $_SERVER['PHP_SELF'];?>";
     }
     else
     {
        document.myform.action="<?php echo $_SERVER['PHP_SELF'];?>";
     }
   }
  </script>
</head>
<body>
<div class="container">
<h1 class="h1">Forensic Exemplars</h1>
<div class="content">

<?php
/////////////////check for the dump folders////////////////

$dir1 = '/home/project2/exemplar';

if (!file_exists($dir1)) {
 	mkdir ( $dir1, 0777, true);
	}

$dir2 = '/home/project2/suspect';

if (!file_exists($dir2)) {
 	mkdir ( $dir2, 0777, true);
	}

$dir3 = '/var/www/html/sam_project2/results';

if (!file_exists($dir3)) {
 	mkdir ( $dir3, 0777, true);
	}

//////////////////////Auto Score Box////////////////////


$myFile = "/home/project2/output";

if (!file_exists($myFile)) {
 	fopen ( $myFile, w);
	}

$fh = fopen($myFile, 'r');
$lines = array();
while (!feof($fh)) {
    $lines[] = fgets($fh, 999);
    if (count($lines) > 30) {
        array_shift($lines);
    }
}
fclose($fh);
foreach($lines as $line)
    echo $line;

?>
<hr>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
Auto:&nbsp;&nbsp;&nbsp;<input value="Score" type="submit" name="name3">
</form>
</div>
<div class="box1">
<!-----------------Upload and Evaluate Box--------------------->
Upload Captures (<500Mbs)
<br>
<br>
<form method="post" name="myform" enctype="multipart/form-data" onsubmit="select()">
<label for="file">Evidence:</label>
<input type="file" name="file" id="file" />
<br>
Name/Number: <input type="text" name="name">
<br>
  <input type="radio" name="type" value="suspect">Suspect<br>
  <input type="radio" name="type" value="exemplar">Exemplar<br>
  <input type="radio" id="radio1" name="pcap" value=".pcap">.pcap<br> 
  <input type="radio" id="radio2" name="flat" value=".txt">text<br>
<input value="Submit" type="submit" />
</form>
<hr>
Evaluate Evidence (builds required files)
<br><br>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
Name/Number: <input type="text" name="name1">
<input value="Submit" type="submit">
</form>
</div>
<br>
<div class="box2">
<!--------------------Get Score Box-------------------------->
Get Similarity Score-
<br>
<br>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
Name/Number: <input type="text" name="name2">
<input value="Submit" type="submit">
</form>
</div>
<br>
<!-----------------------------Results Box-------------------------------->
<div class="box3">
Results-
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<input value="Reset" type="submit" name="">
</form>

<?php
////////////////////////////////isset list/////////////////////
	if(isset($_POST["name1"]))
	{
	eval1();
	}

	if(isset($_POST["name2"]))
	{
	score1();
	}

	if(isset($_POST["name3"]))
	{
	directory1();
	}

	if(isset($_POST["pcap"]))
	{
	pcap_upload();
	}

	if(isset($_POST["flat"]))
	{
	text_upload();
	}

//////////////////////////////functions////////////////////////////

//////////////////eval1-print1/////////////////
function eval1 ()
	{
$type = $_POST["name1"];

mkdir("/home/project2/$type", 0777, true);
chmod("/home/project2/$type", 0777);

echo "See the IPs in ".$type;
echo "<br>";
echo "<a href=/sam_project2/results/$type-suspect.txt>Suspect</a>";
echo "<br>";
echo "<a href=/sam_project2/results/$type-exemplar.txt>Exemplar</a>";
echo "<br>";

//////////////////pass values to print1////////////

$result=shell_exec("/home/project2/combo.sh print1 $type");
echo($result);
	}

////////////////score1-score1///////////////////
function score1()
	{

$type = $_POST["name2"];
$page = "score1";
/////////////pass values to score1//////////////

$result=shell_exec("/home/project2/combo.sh score1 $type");
echo($result);

	}

/////////////////directory-auto1////////////////
function directory1()
	{

unlink('/home/project2/output');
$file = '/home/project2/output';

if ($handleE = opendir('/home/project2/')) {

    while (false !== ($exemplar = readdir($handleE))) {

        if ($exemplar != "." && $exemplar != "..") {
        

		$filenameE = "/home/project2/".$exemplar."/exemplar.txt";

		if (file_exists($filenameE)) {

			if ($handleS = opendir('/home/project2/')) {

    			while (false !== ($suspect = readdir($handleS))) {

        		if ($suspect != "." && $suspect != "..") {


			$filenameS = "/home/project2/".$suspect."/suspect.txt";

			if (file_exists($filenameS)) {

			$combo="$exemplar & $suspect ";
			echo "$combo";

	file_put_contents($file, $combo, FILE_APPEND | LOCK_EX);

/////////////////pass values to auto1///////////////////

			$result=shell_exec("/home/project2/combo.sh auto1 $filenameE $filenameS");
			echo($result);

	file_put_contents($file, $result, FILE_APPEND | LOCK_EX);
			echo "<br>";


			} else {

			}

			}
    			}

    			closedir($handleS);
			}


		} else {

		}

	}
    }

    closedir($handleE);
}

	}

/////////////////////////upload_pcaps///////////////

function pcap_upload()
	{

$new = $_POST["name"];
$type = $_POST["type"];
$value = $_POST["pcap"];

if ($_FILES["file"]["size"] < 500000000)
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "/home/project2/$type/$new");
      echo "Stored in home/project2/$type/$new";
      }
    }
  }
else
  {
  echo "Invalid file";
  }

	}

////////////////////////upload_text//////////////////////

function text_upload()
	{

$new = $_POST["name"];
$type = $_POST["type"];
$value = $_POST["flat"];

mkdir("/home/project2/$new", 0777, true);
chmod("/home/project2/$new", 0777);


if ((($_FILES["file"]["type"] == "application/msword")
|| ($_FILES["file"]["type"] == "application/pdf")
|| ($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
&& ($_FILES["file"]["size"] < 500000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "/home/project2/$new/dump"."_"."$type");
      echo "Stored in home/project2/$new/dump"."_"."$type";
      }
    }
  }
else
  {
  echo "Invalid file";
  }

	}
	
?>

</div>
<br>
</div>
</body>
</html>
