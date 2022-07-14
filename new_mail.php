<form method="post" id="send">

<div class="modal-dialog clearfix" style="padding-top: 0px;">
            <div class="modal-content">
                <div class="modal-header"> 
                    <h4 class="modal-title">New Message</h4>
                </div>
                <div class="modal-body clearfix">

                    <div class="controls">
                        
                        <div class="form-row">
                            <div class="col-md-1 col-sm-1">
                                To:
                            </div>
                            <div class="col-md-11 col-sm-10">
                                <input type="text" class="form-control mail_tags" name="recipient" id="recipient" required />
                            </div>
                        </div>                        
                                   
                        <div class="form-row">
                            <div class="col-md-12">
                                <textarea class="form-control scle" name="message" required ></textarea>
                            </div>
                        </div>                    
                    </div>

                </div>
                <div class="modal-footer">                
                    
                    <button type="submit" class="btn btn-success btn-clean">Send</button>
                </div>
            </div>
</div>
</form>

 <script>
	
	$("#send").submit(function(event) {
		$('.msg').css('display','block');
	    event.preventDefault();
		$('.msg').html('<img src="ajax-loader.gif" alt="Loading" />');
	    var values = $(this).serialize();

    	$.ajax({
        	url: "chat/send_mail.php",
	        type: "POST",
			datatype: "html",
	        data: values,
    	    success: function(data){
    	    $(".msg").html(data);
			 
    	    },
        	error:function(){
        	$(".msg").html('Server Error. Please login again!');
		

     	    }
	    });
	});
	
	
</script>