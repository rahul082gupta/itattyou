<div class="col-md-12 col-sm-12 col-xs-12 main_container">
    <div class="col-md-6 col-sm-6 col-xs-12 left_container">
        <blockquote class="bq3">
            <p><?php echo __("A failed painting doesn’t mean you should quit, but you should be more radical.");?></p>
        </blockquote>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12 right_container">
        <img src="img/logo.png" class="logo">
        
        <?php echo $this->Form->create('User', array(
                            'id' => "msform", 
                            'inputDefaults' => array(
                                'label' => false,
                                'div'   => false
                            ),
                            'class' => 'registration'
                        )
                    );?>
            <fieldset class="pb30">
                <h2 class="fs-title rollsign"><span class="blk"><?php echo __("HE USED I TATT YOU");?> </span></h2>
                <h4 class="roll"><?php echo __("TO ROLL HIM FIRST");?></h4>
                <h6><?php echo __("Join iTattYou to find (and save!) all the things that inspire you");?>.</h6>
                <div class="stepone_userlogin">
                    <?php
                        echo $this->Form->input('name', array('class' => 'required artist_login artist_name bdr-b mt20', 'placeholder' => 'ENTER NAME', 'type' => 'text'));
                    ?>
                    <p id="err_name" class="error"><?php if(isset($error['name'][0])) echo $error['name'][0]; ?></p>
                   
                    <?php
                        echo $this->Form->input('username', array('class' => 'email required artist_login artist_name bdr-b mt20', 'placeholder' => 'ENTER EMAIL', 'type' => 'text'));
                    ?>
                    <p id="err_username" class="error"><?php if(isset($error['username'][0])) echo $error['username'][0]; ?></p>
                    <?php
                    
                        echo $this->Form->input('password', array('class' => 'required artist_login key_name mb20', 'placeholder' => 'ENTER PASSWORD', 'type' => 'password'));
                    ?>
                    <p id="err_password" class="error"><?php if(isset($error['password'][0])) echo $error['password'][0]; ?></p>
                    <a href="" class="btn btn-red">SIGN UP FOR FREE</a>
                    <div class="text-center">Or</div>
                    <a href="#" class="btn btn-blue"><i class="fa fa-facebook"></i> Login <em>With</em> Faccebook</a>
                    <p class="terms_n">Creating an account means you’re okay with iTattYou <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
                </div>
               
                <?php
                    echo $this->Form->button(__('SIGN UP FOR FREE'), array(
                    'class' => 'btn  btn-gray-g button_over',
                    'div' => false,
                    'onclick'=> "return ajax_form_submit('registration',
                        'Users/validate_user_reg_ajax',
                        'registrationWait'
                    ) "
                    )
                    );
                ?>
                <div class="registrationWait"><?php echo $this->Html->image('front/wait.gif',array('height'=>'32px'));?></div>  
               </fieldset>
        <?php echo $this->Form->end();?>
    </div>
</div>
