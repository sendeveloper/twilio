<script>
$(document).ready(function() {
    $('.phone_send').on('click', function(e) {
        var phone = $('#phone').val();
        var msg = $('#message').val();
        var url = "index.php/home/postMessage";
        var formData = new FormData();
        e.preventDefault();
        if (phone == "")
            alert("Please input phone number");
        else if (msg == "")
            alert("Please input message");
        else
        {
            formData.append("phone", phone);
            formData.append("msg", msg);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                processData: false,
                cache: false,
                contentType: false,
                success: function(result){
                    var json = JSON.parse(result);
                    alert(json.msg);
                    if (json.res == false)
                    {
                        $('.email_form').show("slow");
                    }
                }
            });
        }
    })
    $('.email_send').on('click', function(e) {
        var email, phone, formData = new FormData();
        var url = "index.php/home/postEmail";
        email = $('#email').val();
        phone = $('#phone').val();
        e.preventDefault();
        if (email != "")
        {
            formData.append("email", email);
            formData.append("phone", phone);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                processData: false,
                cache: false,
                contentType: false,
                success: function(result){
                    var json = JSON.parse(result);
                    alert(json.msg);
                    if (json.res == true)
                    {
                        $('.ticket_form').show("slow");
                    }
                }
            });
        }
        else
        {
            alert("Please input email number");
        }
    })
    $('.ticket_send').on('click', function(e) {
        var email, ticket, formData = new FormData();
        var url = "index.php/home/postTicket";
        email = $('#email').val();
        ticket = $('#ticket').val();
        e.preventDefault();
        if (email == "")
            alert("Please input email number");
        else if (ticket == "")
            alert("Please input ticket");
        else
        {
            formData.append("email", email);
            formData.append("ticket", ticket);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                processData: false,
                cache: false,
                contentType: false,
                success: function(result){
                    var json = JSON.parse(result);
                    alert(json.msg);
                    document.location.reload();
                }
            });
        }
    })
})
</script>