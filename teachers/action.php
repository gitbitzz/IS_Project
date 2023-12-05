<?php
include "../include/functions.php";
$conn = db_conn();

$action = $_POST['submit'];

switch($action){
	//Adding marks
	case 'submit_marks':
		$exam = $_POST['exam'];
		$class = $_POST['class'];
		$admno = $_POST['regno'];
		$subject = encryptthis($_POST['subject'], $key);
		$count = count($_POST['regno']);

		if(is_array($admno)){
		for($i=0; $i<$count; $i++){
		$open = $_POST['opener'][$i];
		$opener = encryptthis($open, $key);
		$mid = $_POST['midterm'][$i];
		$midterm = encryptthis($mid, $key);
		$end = $_POST['endterm'][$i];
		$endterm = encryptthis($end, $key);
		$jina = $_POST['jina'][$i];
		$jina = encryptthis($jina, $key);
		$regno = $_POST['regno'][$i];
		$average = $open+$mid+$end;
		
		if($average<30){
			$remarks = encryptthis("E", $key);
		}
		else if($average<40){
			$remarks = encryptthis("D", $key);
		}
		else if($average<60){
			$remarks = encryptthis("C", $key);
		}
		else if($average<=80){
			$remarks = encryptthis("B", $key);
		}
		else if($average<=100){
			$remarks = encryptthis("A", $key);
		}
		else{
			$remarks = encryptthis("Invalid", $key);     
		}
		
		$average = encryptthis($average, $key);
			
		$sql = $conn->exec("INSERT INTO marks (examname, class, opener, midterm, endterm, subject, student, admno, average, remarks)
			  VALUES ('$exam', '$class', '$opener', '$midterm', '$endterm', '$subject', '$jina', '$regno', '$average' , '$remarks')");

		}
		if(!$sql) {
		   die("Execute query error, because: ". print_r($conn->errorInfo(),true) );
		   } 
		else {
			echo "
			<script>alert('Marks added successfully!')</script>
			<script>window.location = 'index.php?exams'</script>
			";   
		   }
		}
	break;
	
	case 'update_marks':
		$marksid = $_POST['markid'];
		$open = $_POST['openermarks'];
		$opener = encryptthis($open, $key);
		$mid = $_POST['midtermmarks'];
		$midterm = encryptthis($mid, $key);
		$end = $_POST['endterm'];
		$endterm = encryptthis($end, $key);

		$average = $open+$mid+$end;
		
		if($average<30){
			$remarks = encryptthis("E", $key);
		}
		else if($average<40){
			$remarks = encryptthis("D", $key);
		}
		else if($average<60){
			$remarks = encryptthis("C", $key);
		}
		else if($average<=80){
			$remarks = encryptthis("B", $key);
		}
		else if($average<=100){
			$remarks = encryptthis("A", $key);
		}
		else{
			$remarks = encryptthis("Invalid", $key);     
		}
		
		$average = encryptthis($average, $key);
			
		$sql = $conn->exec("UPDATE marks SET opener = '$opener', midterm = '$midterm', endterm = '$endterm', average = '$average', remarks = '$remarks' WHERE marksid = '$marksid'");

		if(!$sql){
		   die("Execute query error, because: ". print_r($conn->errorInfo(),true) );
		   } 
		else {
			echo "
			<script>alert('Marks updated successfully!')</script>
			<script>window.location = 'index.php?exams'</script>
			";   
		}
	
	break;

}//switch

?>