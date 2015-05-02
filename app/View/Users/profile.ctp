<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU"></script>
<div class="col-md-12 col-sm-12 col-xs-12 main_container">
        <div class="col-md-6 col-sm-6 col-xs-12 left_container">

            <blockquote class="bq3">
              <p>A failed painting doesn’t mean you should quit, but you should be more radical.</p>
            </blockquote> 
           
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 right_container">
            <?php  
                $exp = array();
                $k = 0;
                for($i=1;$i<=50;$i++) {
                    $exp[] = $k; 
                    $k = $k+0.5;
                }
                $exp_val = array_values($exp);
                $exp = array_combine($exp_val, $exp);
                echo $this->Html->image('logo.png', array('class' => 'logo'));
                 echo $this->Form->create('User', array(
                            'id' => "msform", 
                            'inputDefaults' => array(
                                'label' => false,
                                'div'   => false
                            ),
                            'class' => 'validationengine',
                            'default' => false,
                            'action' => 'profile_save'
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
                    
                    <?php
                        echo $this->Form->hidden('User.id');
                        echo $this->Form->input('User.name', array('class' => 'validate[required] artist artist_name', 'placeholder' => 'Enter Artist Name', 'type' => 'text'));
                        echo $this->Form->input('User.studio', array('class' => 'validate[required] artist tattoo_name', 'placeholder' => 'Tattoo Studio Name', 'type' => 'text'));
                    ?>
                   
                        <div class="col-md-7 col-sm-5 col-xs-12 p0">
                           

                            <div class="col-md-12 col-sm-12 col-xs-12 dob_box">
                                <div class="col-md-4 col-sm-4 col-xs-4 dob_text">
                                    <?php  echo $this->Html->image('dob_icon.png', array('style' => 'margin-top:-4px;'));?>DOB
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 p0">
                                      <?php
                                        echo $this->Form->input('dd', array('class' => 'validate[minSize[2], maxSize[2]] dob_space', 'placeholder' => 'DD', 'type' => 'text'));
                                    ?>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 p0">

                                    <?php
                                        echo $this->Form->input('mm', array('class' => 'validate[minSize[2], maxSize[2]] dob_space', 'placeholder' => 'MM', 'type' => 'text'));
                                    ?>
                                   
                                </div>
                                 <div class="col-md-3 col-sm-3 col-xs-3 p0">
                                      <?php
                                        echo $this->Form->input('yy', array('class' => 'validate[minSize[4], maxSize[4]] dob_space', 'placeholder' => 'YYYY', 'type' => 'text'));
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5 col-xs-12 exp_box">
                            <div class="col-md-3 col-sm-3 col-xs-3 dob_text">Exp:</div>
                            <div class="col-md-9 col-sm-3 col-xs-3 dob_text">
                                <!-- <select class="select_exp">
                                    <option>Select Exp</option>
                                    <option>Select one</option>
                                </select> -->
                                 <?php
                                        echo $this->Form->input('experience', array('class' => 'validate[required] select_exp', 'empty' => 'Select Exp', 'type' => 'select', 'div' => false ,'label' => false, 'options' => $exp));
                                    ?>
                            </div>
                        </div>
                        
                         <?php
                                echo $this->Form->input('tatoo_id', array('class' => 'validate[required] artist art_icon', 'placeholder' => 'Art Speciality', 'type' => 'text'));
                            ?>
                        <div class="col-md-5 col-sm-5 col-xs-12 p0">
                            
                            <?php
                                echo $this->Form->input('contact', array('class' => 'validate[minSize[10], maxSize[10]] artist contact_num', 'placeholder' => 'Contact Number', 'type' => 'text'));
                            ?>
                        </div>

                        <div class="col-md-7 col-sm-7 col-xs-12 p0">
                           
                             <?php
                                echo $this->Form->input('username', array('class' => 'validate[required, custom[email]] artist email_icon', 'placeholder' => 'Enter Email', 'type' => 'text' ,'disabled' => true));
                            ?>
                        </div>
                        
                        
                        
                        <?php
                            echo $this->Form->input('address', array('class' => 'artist addressmap address_icon', 'placeholder' => 'Address', 'type' => 'text'));
                        ?>

                    </div>
                    <!--input type="button" name="next" class="next action-button button_over" value="COMPLETED & NEXT" /-->
                    <?php echo $this->Form->submit('COMPLETED & NEXT',array('id'=>'YourButtonName','class'=>'next action-button button_over btnSubmit'));?>
                    <a href = 'javascript:void(0)' class = 'next11' style="display:none;"> click</a>
                </fieldset>
                 <?php $this->Form->end();?>
                <?php  
                 echo $this->Form->create('User', array('action' => 'step2')
                    );
              ?> 

                <fieldset>
                    
                    <h3 class="fs-title">
                    <?php 
                        echo $this->Form->hidden('User.id');
                        echo $this->Html->image('hi.png');
                    ?>
                    <br>
                    <span class="namebox"><?php echo $this->Session->read('Auth.User.name');?></span>
                    </h3>

                    <div class="img_upload_container">
                        <?php echo $this->Html->image('user_image.png', array('class' => 'img-responsive m0auto'));?>

                        <div style="position: relative;">
                            
                            <?php echo $this->Html->image('uplaod_image.png', array('class' => 'myAvatar', 'style' => 'position:absolute; top:0;  z-index:1; top: -67px;  right: 103px;', 'width' => '50', 'height' => '50'));?>
                            <input type="file" name="newAvatar" id="newAvatar" style="width:50px; height:50px; position:absolute; top:0px;  z-index:2; opacity:0;top: -67px;  right: 103px; cursor:pointer;" />
                        </div>
                    </div>
                    <h4 class="fs-subtitle">Upload Profile Photo</h4>
                    <!-- <input type="button" name="previous" class="previous action-button" value="Previous" /> -->
                   
                     <?php
                            echo $this->Form->button(__('FINISH'), array(
                                'class' => 'button_over action-button',
                                'div' => false
                            )
                        );
                    ?>
                </fieldset>
            <?php $this->Form->end();?>
        </div>
    </div>


<script>
    $(function() {

    var autocomplete = new google.maps.places.Autocomplete($(".addressmap")[0], {});
    google.maps.event.addListener(autocomplete, 'place_changed', function(e) {
        var place = autocomplete.getPlace();
    });

    $(document.body).on("click", ".btnSubmit", function(e) {
        e.preventDefault();
        var form = $(this).parents('form');
        $.ajax({
            type: "POST",
            url: '<?php echo HTTP_ROOT;?>Users/profile_save.json',
            data: form.serialize(),
            success: function(response){  
                $('div.container.container_error').remove();       
                if(response.result.status == '1') {
                    $('.namebox').text(response.result.name);
                    $('div#content').prepend("<div class='container container_error'><div class='row'><div data-alert class='alert alert-error alert-success'>"+ response.result.msg +"<button type='button' class='close' data-dismiss='alert'>×</button></div></div></div>");
                    $(".next11").trigger('click');
                 } else {
                    $('div#content').prepend("<div class='container container_error'><div class='row'><div data-alert class='alert alert-error alert-danger'>"+ response.result.msg +"<button type='button' class='close' data-dismiss='alert'>×</button></div></div></div>");
                }
                $(window).scrollTop(0,0);
            }
        });
    });


    //jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

 
    $(document.body).on('click', '.next11', function(e) {
        //e.preventDefault();
        if(animating) return false;
        animating = true;
        
        current_fs = $(this).parents('fieldset');
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

     //$(".next11").trigger('click');

    });
    </script>
