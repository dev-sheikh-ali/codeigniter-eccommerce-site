//Jquery validation.(login & registration).
jQuery.validator.addMethod("noSpace", function(value, element) { 
    return value == '' || value.trim().length != 0;  
}, "No space please and don't leave it empty");
jQuery.validator.addMethod("customEmail", function(value, element) { 
  return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value ); 
}, "Please enter valid email address!");
$.validator.addMethod( "alphanumeric", function( value, element ) {
return this.optional( element ) || /^\w+$/i.test( value );
}, "Letters, numbers, and underscores only please" );
var $registrationForm = $('#registration');
if($registrationForm.length){
  $registrationForm.validate({
      rules:{
          firstname: {
              required: true,
              alphanumeric: true,
              noSpace: true

          },
          lastname: {
            required: true,
            alphanumeric: true,
            noSpace: true,

        },

          email: {
              required: true,
              customEmail: true,
          },
          password: {
              required: true,
              maxlength: 15,
              minlength: 6
          },
          cpassword: {
              required: true,
              equalTo: '#password',
              maxlength: 15,
              minlength: 6

          },
          gender: {
              required: true
          }
      },
      messages:{
          firstname: {
              required: 'Please enter first name!'
          },
          lastname: {
            required: 'Please enter last name!'
        },

          email: {
              required: 'Please enter email!',
              email: 'Please enter valid email!',
          },
          password: {
              required: 'Please enter password!'
          },
          cpassword: {
              required: 'Please confirm password!',
              equalTo: 'Please enter same password!'
          },
          gender: {
            required: 'Please select gender!'
        }
      },
      errorPlacement: function(error, element) 
      {
        if (element.is(":radio")) 
        {
            error.appendTo(element.parents('.gender'));
        }
        
        else 
        { 
            error.insertAfter( element );
        }
        
       }
  });
}

//login JQuery validation.
var $loginForm = $('#login');
if($loginForm.length){
    $loginForm.validate({
        rules:{
  
            email: {
                required: true,
                customEmail: true,
            },
            password: {
                required: true,
                maxlength: 15,
                minlength: 6
            }
        },
        messages:{
                email: {
                required: 'Please enter email!',
                email: 'Please enter valid email!',
            },
            password: {
                required: 'Please enter password!'
            }
        },
    });
  }
  
   //Register New User Ajax.
   $('#registration').submit(function(e){
    //e.preventDefault();
    var form = this;
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
            $(form).find('span.error-text').text('');
        },
        success:function(data){
            if($.isEmptyObject(data.error)){
                if(data.code == 1){
                    $(form)[0].reset();
                    alert(data.msg);
                    welcome.location =  site_url('pages');
                }else{
                    alert(data.msg);
                }
            }else{
                $.each(data.error, function(prefix, val){
                    $(form).find('span.'+prefix+'_error').text(val);
                });
            }
    }
    });
});

   //login Ajax.
    $('#login').submit(function(e){
    //e.preventDefault();
    var form = this;
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
            $(form).find('span.error-text').text('');
        },
        success:function(data){
            if($.isEmptyObject(data.error)){
                if(data.code == 1){
                    $(form)[0].reset();
                    alert(data.msg);
                }else{
                    e.preventDefault();
                    alert(data.msg);
                }
            }else{
                $.each(data.error, function(prefix, val){
                    $(form).find('span.'+prefix+'_error').text(val);
                });
            }
    }
    });
});

