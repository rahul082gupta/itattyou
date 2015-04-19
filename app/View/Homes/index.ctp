<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>demo</title>
	
	<!-- core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    
   
    <link rel="shortcut icon" href="images/ico/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/ico/favicon.ico" type="image/x-icon">
    
</head>

<body>

    <div class="col-md-12 col-sm-12 col-xs-12 main_container">
        <div class="col-md-6 col-sm-6 col-xs-12 left_container">

            <blockquote class="bq3">
              <p>A failed painting doesn’t mean you should quit, but you should be more radical.</p>
            </blockquote> 
           
        </div>



        <div class="col-md-6 col-sm-6 col-xs-12 right_container">
            <img src="img/logo.png" class="logo">
            <form id="msform">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">Account Setup</li>
                    <li>Social Profiles</li>
                </ul>
                <!-- fieldsets -->
                <fieldset>

                    
                    <h2 class="fs-title"><span class="blk">Create </span>Your Profile</h2>
                    <div class="stepone">
                    <input type="text" name="" class="artist artist_name" placeholder="Enter Artist Name" />
                    <input type="text" name="" class="artist tattoo_name" placeholder="Tattoo Studio Name" />

                        <div class="col-md-7 col-sm-5 col-xs-12 p0">
                           

                            <div class="col-md-12 col-sm-12 col-xs-12 dob_box">
                                <div class="col-md-4 col-sm-4 col-xs-4 dob_text">
                                    <img src="img/dob_icon.png">DOB
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 p0">
                                    <input type="text" name="" placeholder="DD" class="dob_space"/>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 p0">
                                    <input type="text" name="" placeholder="MM" class="dob_space"/>
                                </div>
                                 <div class="col-md-3 col-sm-3 col-xs-3 p0">
                                    <input type="text" name="" placeholder="YYYY" class="dob_space"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5 col-xs-12 exp_box">
                            <div class="col-md-3 col-sm-3 col-xs-3 dob_text">Exp:</div>
                            <div class="col-md-9 col-sm-3 col-xs-3 dob_text">
                                <select class="select_exp">
                                    <option>Select Exp</option>
                                    <option>Select one</option>
                                </select>
                            </div>
                        </div>
                        
                        <input type="text" name="" class="artist art_icon" placeholder="Art Speciality" />

                        <div class="col-md-5 col-sm-5 col-xs-12 p0">
                            <input type="text" name="" class="artist contact_num" placeholder="Contact Number"/>
                        </div>

                        <div class="col-md-7 col-sm-7 col-xs-12 p0">
                            <input type="text" name="" class="artist email_icon" placeholder="Enter Email"/>
                        </div>
                        
                        
                        <textarea placeholder="Address" class="artist address_icon"></textarea>

                    </div>
                    <input type="button" name="next" class="next action-button button_over" value="COMPLETED & NEXT" />
                </fieldset>


                <fieldset>
                    
                    <h3 class="fs-title"><img src="img/hi.png"><br>Name Kumar</h3>

                    

                    <div class="img_upload_container">
                        <img src="img/user_image.png" class="img-responsive m0auto">

                        <div style="position: relative;">
                        <img src="img/uplaod_image.png" width="50" height="50" alt="" class="myAvatar" style="position:absolute; top:0;  z-index:1; top: -67px;  right: 103px;" />
                        <input type="file" name="newAvatar" id="newAvatar" style="width:50px; height:50px; position:absolute; top:0px;  z-index:2; opacity:0;top: -67px;  right: 103px;" />
                    </div>
                    </div>
                    <h4 class="fs-subtitle">Upload Profile Photo</h4>
                    <!-- <input type="button" name="previous" class="previous action-button" value="Previous" /> -->
                    <input type="button" name="next" class="button_over action-button" value="FINISH" />
                </fieldset>
            </form>
        </div>
    </div>










    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!-- jQuery easing plugin --> 
    <script src="js/jquery.easing.min.js" type="text/javascript"></script> 
        <script>
    $(function() {

    //jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    $(".next").click(function(){
        if(animating) return false;
        animating = true;
        
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        //show the next fieldset
        next_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50)+"%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'transform': 'scale('+scale+')'});
                next_fs.css({'left': left, 'opacity': opacity});
            }, 
            duration: 800, 
            complete: function(){
                current_fs.hide();
                animating = false;
            }, 
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".previous").click(function(){
        if(animating) return false;
        animating = true;
        
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        
        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1-now) * 50)+"%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'left': left});
                previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
            }, 
            duration: 800, 
            complete: function(){
                current_fs.hide();
                animating = false;
            }, 
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".submit").click(function(){
        return false;
    })

    });
    </script>
</body>
</html>