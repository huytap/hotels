function getEmail(){
	if($.trim($('#email_receiver').val()) == ''){
		alert('Please enter your email');
		$('#email_receiver').focus();
	}else if(!checkMail($('#email_receiver').val())){
		alert('Wrong email');
		$('#email_receiver').focus();
	}else{
		$.ajax({
			url: rootUrl+'ajax/getemail',
			data: {email:$('#email_receiver').val()},
			type: 'post',
			dataType: 'json',
			success: function(data){
				if(data){
					$('#email_receiver').val('');
					alert('Thank you for your signup')
				}else{
					alert('This email is registered')
				}
			}
		})
	}
}
function checkMail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}