$.validator.setDefaults({ ignore: ":hidden:not(select)" });

$.validator.addMethod('multiemail', function(value, element) {
    if (this.optional(element)) {
        return true;
    }

    var emails = value.split(','),
        valid = true;
 
    for (var i = 0, limit = emails.length; i < limit; i++) {
        value = emails[i];
        valid = valid && jQuery.validator.methods.email.call(this, value, element);
    }
 
    return valid;
}, "Please enter valid email with comma separated.");

$.validator.addMethod('multinumber', function(value, element) {
    if (this.optional(element)) {
        return true;
    }
    console.log(value);
    var emails = value.split(','),
        valid = true;
 
    for (var i = 0, limit = emails.length; i < limit; i++) {
        value = emails[i];
        valid = this.optional(element) || /^((\+\d{1,3}(-|)?\(?\d\)?(-|)?\d{1,5})|(\(?\d{2,6}\)?))(-|)?(\d{3,4})(-|)?(\d{4})(( x| ext)\d{1,5}){0,1}$/.test(value); 
    }
 
    return valid;
}, "Please enter valid numbers with comma separated.");

$.validator.addMethod('url_validate', function(value) {
    if(value != "") {
        var result = $.ajax({ 
                        async:false, 
                        url:"/app/check_url",
                        data:'url='+ value
                    });
        if(result.responseText == 'true') return true; else return false; 
    } else{
        return true;
    }
} , "Please provide a valid url.");

$.validator.addMethod('decimal', function(value, element) {
    return this.optional(element) || /^\+?[0-9]*\.?[0-9]+$/.test(value); 
}, "Please enter a correct number, format xxxx.xxx");

$.validator.addMethod('phonenumber', function(value, element) {
    return this.optional(element) || /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/.test(value); 
}, "Please enter a valid phone number");

$(document).ready(function() {
	if($(".submit, .btn").length) {
        var $btn = $(".submit, .btn").not('.novalidateBtnClick');

        $btn.on("click", function() {

        	var $this = $(this);
        	var form = $this.parents("form");
            if(form.length) { 
                form.validate();
                if(form.valid()) { 
                    form.submit(function() { console.log('hii');
                        $this.val("Loading...");
                        $this.attr("disabled", "disabled");
                    });
                } else {

                }
            }
        });
    }
});