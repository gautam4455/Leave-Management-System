<?php
	require('top.php');
		
	$leave_id='';
	$leave_from='';
	$leave_to='';
	$employee_id='';
	$leave_description='';
	
	if(isset($_GET['id'])) {
		$id=mysqli_real_escape_string($con,$_GET['id']);
		/*if($_SESSION['ROLE']==2 && $_SESSION['USER_ID']!=$id) {
			echo "Id: ".$id;
			die('<br/>Access denied. User mismatched.');
		}*/
		$res=mysqli_query($con,"select * from `leave` where id='$id'");
		$row=mysqli_fetch_assoc($res);
		$leave_id=$row['leave_id'];
		$leave_from=$row['leave_from'];
		$leave_to=$row['leave_to'];
		$employee_id=$row['employee_id'];
		$leave_description=$row['leave_description'];
	}
	
	if(isset($_POST['submit'])) {
		$leave_id=mysqli_real_escape_string($con,$_POST['leave_id']);
		$leave_from=mysqli_real_escape_string($con,$_POST['leave_from']);
		$leave_to=mysqli_real_escape_string($con,$_POST['leave_to']);
		$employee_id=$_SESSION['USER_ID'];
		$leave_description=mysqli_real_escape_string($con,$_POST['leave_description']);
		if($id>0) {
			echo "Employee ID: ".$employee_id;
			$sql="update `leave` set leave_id='$leave_id', leave_from='$leave_from', leave_to='$leave_to', employee_id='$employee_id', leave_description='$leave_description' where id='$id' and employee_id='$employee_id'";
		} else {
			$sql="insert into `leave`(leave_id,leave_from,leave_to,employee_id,leave_description,leave_status) values('$leave_id','$leave_from','$leave_to','$employee_id','$leave_description',1)";
		}
		mysqli_query($con,$sql);
		header('location:leave.php');
		die();
	}
	
?>

<div class="content pb-0">
	<div class="animated fadeIn">
	   <div class="row">
		  <div class="col-lg-12">
			 <div class="card">
				<div class="card-header"><strong>Add Employee</strong><small> Form</small></div>
				<div class="card-body card-block">
					<form method="post">
						<div class="form-group">
							<label class=" form-control-label">Leave Type</label>
							<select name="leave_id" class="form-control" required>
								<option value="">Select Leave</option>
								<?php
									$res=mysqli_query($con,"select * from leave_type order by leave_type desc");
									while($row=mysqli_fetch_assoc($res)) {
										if($leave_id==$row['id']) {
											echo "<option selected value=".$row['id'].">".$row['leave_type']."</option>";
										} else {
										echo "<option value=".$row['id'].">".$row['leave_type']."</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label class=" form-control-label">From Date</label>
							<input type="date" value="<?php echo $leave_from; ?>" name="leave_from" class="form-control" required>
						</div>
						<div class="form-group">
							<label class=" form-control-label">To Date</label>
							<input type="date" value="<?php echo $leave_to; ?>" name="leave_to" class="form-control" required>
						</div>
						<div class="form-group">
							<label class=" form-control-label">Leave Description</label>
							<input type="text" value="<?php echo $leave_description; ?>" name="leave_description" placeholder="Enter leave description" class="form-control">
						</div>
					   <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
							<span id="payment-button-amount">Submit</span>
					   </button>
					</form>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
 </div>
 <?php
	require('footer.php');
 ?>