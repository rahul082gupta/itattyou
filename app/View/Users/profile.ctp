<div class="col-md-12 col-sm-12 col-xs-12 main_container">
        <div class="col-md-6 col-sm-6 col-xs-12 left_container">

            <blockquote class="bq3">
              <p>A failed painting doesn’t mean you should quit, but you should be more radical.</p>
            </blockquote> 
           
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 right_container">
            <?php  
                echo $this->Html->image('logo.png', array('class' => 'logo'));
                 echo $this->Form->create('User', array(
                            'id' => "msform", 
                            'inputDefaults' => array(
                                'label' => false,
                                'div'   => false
                            ),
                            'class' => 'profile'
                        )
                    );
            ?>
            
                <!-- progressbar -->
                <div class="col-md-12 col-sm-12 col-xs-12 bullets_container">
                    <ul id="progressbar">
                        <li class="active">  </li> 
                        <li> </li>
                    </ul>
                </div>
                
                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title"><span class="blk">Create </span>Your Profile</h2>
                    <div class="stepone">
                    <!-- <input type="text" name="" class="artist artist_name" placeholder="Enter Artist Name" /> -->
                    
                    <?php
                        echo $this->Form->input('User.studio', array('class' => 'required artist tattoo_name', 'placeholder' => 'Tattoo Studio Name', 'type' => 'text'));
                    ?>
                    <p id="err_studio" class="error" style="display: <?php echo isset( $error['studio'][0] ) ? 'block' : 'none' ?> "><?php if(isset($error['studio'][0])) echo $error['studio'][0]; ?></p>

                        <div class="col-md-7 col-sm-5 col-xs-12 p0">
                           

                            <div class="col-md-12 col-sm-12 col-xs-12 dob_box">
                                <div class="col-md-4 col-sm-4 col-xs-4 dob_text">
                                    <?php  echo $this->Html->image('dob_icon.png', array('style' => 'margin-top:-4px;'));?>DOB
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 p0">
                                      <?php
                                        echo $this->Form->input('dd', array('class' => 'dob_space', 'placeholder' => 'DD', 'type' => 'text'));
                                    ?>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 p0">

                                    <?php
                                        echo $this->Form->input('mm', array('class' => 'dob_space', 'placeholder' => 'MM', 'type' => 'text'));
                                    ?>
                                   
                                </div>
                                 <div class="col-md-3 col-sm-3 col-xs-3 p0">
                                      <?php
                                        echo $this->Form->input('yy', array('class' => 'dob_space', 'placeholder' => 'YYYY', 'type' => 'text'));
                                    ?>
                                </div>
                                 <p id="err_yy" class="error" style="display: <?php echo isset( $error['yy'][0] ) ? 'block' : 'none' ?> "><?php if(isset($error['yy'][0])) echo $error['yy'][0]; ?></p>
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
                    <!--input type="button" name="next" class="next action-button button_over" value="COMPLETED & NEXT" /-->
                    <?php echo $this->Form->submit('COMPLETED & NEXT',array('id'=>'YourButtonName','class'=>'next action-button button_over','onclick'=>'your onclick function'));?>
                </fieldset>
                 <?php $this->Form->end();?>
                <?php  
                 echo $this->Form->create('User', array('action' => 'step2')
                    );
              ?> 

                <fieldset>
                    
                    <h3 class="fs-title"><img src="img/hi.png"><br>Name Kumar</h3>

                    <div class="img_upload_container">
                        <img src="img/user_image.png" class="img-responsive m0auto">

                        <div style="position: relative;">
                            <img src="img/uplaod_image.png" width="50" height="50" alt="" class="myAvatar" style="position:absolute; top:0;  z-index:1; top: -67px;  right: 103px;" />
                            <input type="file" name="newAvatar" id="newAvatar" style="width:50px; height:50px; position:absolute; top:0px;  z-index:2; opacity:0;top: -67px;  right: 103px; cursor:pointer;" />
                        </div>
                    </div>
                    <h4 class="fs-subtitle">Upload Profile Photo</h4>
                    <!-- <input type="button" name="previous" class="previous action-button" value="Previous" /> -->
                   
                     <?php
                            echo $this->Form->button(__('FINISH'), array(
                                'class' => 'button_over action-button',
                                'div' => false,
                                'onclick'=> "return ajax_form_submit('profile',
                                    'Users/validate_user_profile_ajax',
                                    'registrationWait'
                                ) "
                            )
                        );
                    ?>
                </fieldset>
            <?php $this->Form->end();?>
        </div>
    </div>


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
        next_fs = $('.main_container').find('fieldset').eq('1'); 
        
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
        $("#progressbar li").eq($("fieldset").index('0')).removeClass("active");
        
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

    

    });
    </script>
