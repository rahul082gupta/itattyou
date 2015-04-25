<div class="col-md-12 col-sm-12 col-xs-12 main_container">
    <div class="col-md-6 col-sm-6 col-xs-12 left_container">
        <blockquote class="bq3">
            <p><?php echo __("A failed painting doesn’t mean you should quit, but you should be more radical.");?></p>
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
                            'class' => 'validationengine'
                        )
                    );?>
            <fieldset class="pb30">
                <h2 class="fs-title rollsign"><span class="blk"><?php echo __("HE USED I TATT YOU");?> </span></h2>
                <h4 class="roll"><?php echo __("TO ROLL HIM FIRST");?></h4>
                <h6><?php echo __("Join iTattYou to find (and save!) all the things that inspire you");?>.</h6>
                <div class="stepone_userlogin">
                    <?php
                        echo $this->Form->input('name', array('class' => 'validate[required] artist_login artist_name bdr-b mt20', 'placeholder' => 'ENTER NAME', 'type' => 'text'));
                    ?>
                    <p id="err_name" class="error"><?php if(isset($error['name'][0])) echo $error['name'][0]; ?></p>
                   
                    <?php
                        echo $this->Form->input('username', array('class' => 'validate[required,custom[email]] artist_login artist_name bdr-b ', 'placeholder' => 'ENTER EMAIL', 'type' => 'text'));
                    ?>
                    <p id="err_username" class="error"><?php if(isset($error['username'][0])) echo $error['username'][0]; ?></p>
                    <?php
                    
                        echo $this->Form->input('password', array('class' => 'validate[required] artist_login key_name mb20 ', 'placeholder' => 'ENTER PASSWORD', 'type' => 'password' ,'minimum' => '6'));
                    ?>
                    <p id="err_password" class="error"><?php if(isset($error['password'][0])) echo $error['password'][0]; ?></p>
                    <a href="<?php echo Router::url(array('controller' => 'Users' ,'action' => 'social_login/Google'));?>" class="btn btn-red">Google Login</a>
                     
                    <div class="text-center">Or</div>
                    <a href="<?php echo Router::url(array('controller' => 'Users' ,'action' => 'fblogin'));?>" class="btn btn-blue"><i class="fa fa-facebook"></i> Login <em>With</em> Faccebook</a>
                    <p class="terms_n">Creating an account means you’re okay with iTattYou <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
                </div>
               
                <?php
                    echo $this->Form->button(__('SIGN UP FOR FREE'), array(
                    'class' => 'btn  btn-gray-g button_over',
                    'div' => false,
                   
                    )
                    );
                ?>
               </fieldset>
        <?php echo $this->Form->end();?>
    </div>
</div>
