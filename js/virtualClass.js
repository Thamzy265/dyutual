$(function(){

    displayMessages();
    displayParticipants();

    setInterval(function(){
        displayMessages();
        displayParticipants();
    },8000)

    $('#chatForm').on('keypress',function (e) {
        if(e.which ==13){
            var message = $('#message').val();
            console.log(message);
            if(message!=''){

                    $.post('../../../route/route.php',{
                        message:message,
                    },function (data,status) {
                        if (status=='success'){
                            console.log(data);
                        // $('.msg-tx').html('Message has been sent successfuly!').addClass('alert alert-success');
                        }else {
                            //$('.msg-tx').html('Sorry failed to send message, try again...').addClass('alert alert-danger');
                            console.log("failed");
                        }
                    })
            

            }else {
                $('.msg-tx').html('Please fill in your name and write message!').addClass('alert alert-success');
            }
        }

    }
    );
    $('#btn-msg').click(function () {
        var message = $('#message').val();
        console.log(message);
        if(message!=''){

                $.post('../../../route/route.php',{
                    message:message,
                },function (data,status) {
                    if (status=='success'){
                        console.log(data);
                       // $('.msg-tx').html('Message has been sent successfuly!').addClass('alert alert-success');
                    }else {
                        //$('.msg-tx').html('Sorry failed to send message, try again...').addClass('alert alert-danger');
                        console.log("failed");
                    }
                })
           

        }else {
            $('.msg-tx').html('Please fill in your name and write message!').addClass('alert alert-success');
        }


    })

    function displayMessages(){
        $.ajax({
            type: "GET",
            url: "../../../route/route.php?messages=true",
            dataType:"html",
            success: function(response){
                $("#responsecontainer").html(response);
            }
        })
    }
    
    function displayParticipants(){
        $.ajax({
            type: "GET",
            url: "../../../route/route.php?participants=true",
            dataType:"html",
            success: function(response){
                $("#participantsContainer").html(response);
            }
        })
    }

    
});