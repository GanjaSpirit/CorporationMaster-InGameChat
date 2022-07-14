<?php
//get the current session
@session_start();
//connect to the db
require(__DIR__.'/db_connect.php');

$user = $_SESSION['user_name'];
$id   = $_POST['id'];

$sendtest   = $_POST['sender'];
if ($sendtest =='') {echo 'refresh the page!';}
echo $id. " " . $user. " ".$sendtest;
//query the user table for user id
$u_query = "SELECT sender,receiver FROM messages WHERE id = '".$id."'";
$outcome = mysqli_query($link,$u_query) or die("failed ". mysqli_error());
$a = mysqli_fetch_array($outcome);
$sender = $a['sender'];
$receiver = $a['receiver'];
if ($sender == $user) {$sender = $receiver;}

		$u_query2 = "SELECT img FROM users WHERE user_name = '".$user."'";
		$outcome2 = mysqli_query($link,$u_query2) or die("failed ". mysqli_error());
		$a2 = mysqli_fetch_array($outcome2);
		$img2 = $a2['img'];
		
		if (file_exists("../img/uploads/".$img2)) {

		if ($img2 != "../img/user.png") {$img2 = "../img/uploads/".$img2;}
		
		} else {$img2 = "../img/user.png";}

	function timepassed ($time)
	{
	    $time = time() - $time; 
	    $timeident = array (31536000 => 'year', 2592000 => 'month', 604800 => 'week', 86400 => 'day', 3600 => 'hour', 60 => 'minute',   1 => 'second'
	    );
	    foreach ($timeident as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	    }
	}
	
	//query the received messages
	$query = "SELECT * FROM messages
	 WHERE receiver = '".$user."' AND sender = '".$sender."'
	 UNION 
	 SELECT * FROM messages
	 WHERE receiver = '".$sender."' AND sender = '".$user."'
	 
	ORDER BY time DESC Limit 15";
	
	$received_query = mysqli_query($link,$query) or die("Query Failed" . mysqli_error());
	
?>

                        
<div class="block block-drop-shadow">

                    <div class="header">
                        <h2>Chat conversation with <?php echo $sender; ?> </h2>
                    </div>
                    
                 <form method="post" id="reply">

				    <div class="footer">
		                        <div class="input-group">
		                            
		                            <input type="hidden" name="recipient" value="<?php echo $sender; ?>" />
		                            <input type="text" class="form-control" name="message" required placeholder="message..">
		                            <span type="submit" class="input-group-addon"><i class="icon-comment"></i></span>
		                        </div>                        
		                    </div>
		
		
		</form>
                    
                    <div class="content messages npr npt">   <div class="scroll" style="height: 200px;">
<?php
	
	
if (mysqli_num_rows($received_query) >0) {  
	
	while($row = mysqli_fetch_array($received_query) ){
		$senderq = $row['sender'];
		$receiverq = $row['receiver'];
                $messageq = $row['message'];
		$dateq = $row['time'];
		$seen_flagq = $row['seen_flag'];
		
		//update seen flag
		mysqli_query($link,"UPDATE messages SET seen_flag = 1 WHERE receiver ='" . $user."'") or die("Failed update 1 " . mysqli_error());
		
		//query the sender image
		$u_query = "SELECT img FROM users WHERE user_name = '".$senderq."'";
		$outcome = mysqli_query($link,$u_query) or die("failed ". mysqli_error());
		$a = mysqli_fetch_array($outcome);
		$img = $a['img'];
		
		if (file_exists("../img/uploads/".$img)) {

		if ($img != "../img/user.png") {$img = "../img/uploads/".$img;}
		
		} else {$img = "../img/user.png";}
		
		
		
		if ($senderq != $user) {

		?>                  
                        <div class="messages-item">
                            <img src="<?php echo $img; ?>" class="img-circle img-thumbnail" style="max-width: 35px;max-height: 35px;min-width: 35px;min-height: 35px;"/>
                            <div class="messages-item-text"><?php echo $senderq; ?>: <?php echo $messageq; ?><div class="messages-item-date pull-right"><?php echo timepassed($dateq) .' ago' ?></div></div>
                            
                        </div>
                 <?php  } else { ?>
                        <div class="messages-item inbox">
                             <img src="<?php echo $img2; ?>" class="img-circle img-thumbnail" style="max-width: 35px;max-height: 35px;min-width: 35px;min-height: 35px;"/>
                            <div class="messages-item-text">You: <?php echo $messageq; ?><div class="messages-item-date pull-right"><?php echo timepassed($dateq) .' ago' ?></div></div>
                        </div> 

<?php } } }?>

			</div>


</div> 




</div>

<script>
	
	$("#reply").submit(function(event) {
		$('.maincontent').css('display','block');
	    
		$('.maincontent').html('<img src="ajax-loader.gif" alt="Loading" />');
	    var values = $(this).serialize();

    	$.ajax({
        	url: "chat/send_reply.php",
	        type: "POST",
			datatype: "html",
	        data: values,
    	    success: function(data){
    	    $(".maincontent").html(data);
			 
    	    },
        	error:function(){
        	$(".maincontent").html('Server Error. 2!');
		

     	    }
	    });
	});
	
	
</script>