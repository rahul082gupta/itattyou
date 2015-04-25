<style>
    body {
        background: none;
    }
</style>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="container">
        <div class="col-md-3 col-sm-3 col-xs-3 logo_inner_main">
            <?php echo $this->Html->image('logo_inner.png', array('class' => 'logo_inner img-responsive'));?>
        </div>


        <div class="col-md-9 col-sm-9 col-xs-9 search_space">
            <div class="col-md-3 col-sm-3 col-xs-3 p0">
                <div class="styled-select">
                   <select>
                      <option>New Delhi</option>
                      <option>The second option</option>
                   </select>
                </div>
            </div>

            <div class="col-md-7 col-sm-7 col-xs-7 p0">
                <input type="text" class="search_name">
                <button type="button" class="go_btn">Go</button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 header_brush">

</div>


<div class="container">

    <div class="col-md-8 col-sm-8 col-xs-12 lt_container">
        <div class="col-md-4 col-sm-4 col-xs-12 pl0">

            <div class="col-md-12 col-sm-12 col-xs-12 update_cover">
                <i class="fa fa-camera"></i> Update Cover Photo
            </div>
        </div>

        <div class="col-md-8 col-sm-4 col-xs-4 update_cover">
            <div class="col-md-4 col-sm-4 col-xs-12">
                Ratings for Artist 
            </div>
            
            <div class="col-md-8 col-sm-8 col-xs-12">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                 - 6.5
            </div>
        </div>



        <div class="follower_container">
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="follow">Follower</div>
                <div class="follow_numbers">1252</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="follow">Following</div>
                <div class="follow_numbers">150</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="follow">Project Views</div>
                <div class="follow_numbers">15520</div>

            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <a href="" class="btn btn-info pull-right">Follow</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <a href="" class="btn btn-default pull-left">Contact Artist</a>
            </div>
        </div> 


        <div class="col-md-12 col-sm-12 col-xs-12 left_lower">
            <h2 class="h2_ds">Artist Bio</h2>
            <p><?php echo $artistInfo['Artist']['about']; ?> </p>

            <h2 class="h2_ds">Artist Profile</h2>

            <ul class="thumbnails">
                 <div class="">
                    <?php if($artistInfo['ArtistArt']) {

                            foreach($artistInfo['ArtistArt'] as $image) {
                     ?>
                                <li class="col-md-2 col-sm-2 col-xs-12 p5">
                                  
                                    <a class="thumbnail" rel="lightbox[group]" href="<?php echo $image['image']?>">
                                        <img class="group1" src="<?php echo $image['image']?>" title="Image Title" />
                                    </a>
                                    
                                </li>
                            <?php } 
                        } else { ?>
                            <li class="col-md-6 col-sm-6 col-xs-12 p5">
                                No Profile found.
                            </li>
                    <?php } ?>

                </div>
            </ul>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 left_lower">
            <h2 class="h2_ds">Artist Videos</h2>


            <div class="">
                <div class="col-md-4 col-sm-4 col-xs-4 p5">
                    <object width="100%" height="150"
                    data="http://youtube.com/watch?v=Q3lvhJy3mYE">
                    </object>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4 p5">
                    <object width="100%" height="150"
                    data="http://www.youtube.com/v/XGSy3_Czz8k">
                    </object>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4 p5">
                    <object width="100%" height="150"
                    data="http://www.youtube.com/v/XGSy3_Czz8k">
                    </object>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 top_artist">

            <div class="col-md-6 col-sm-6 col-xs-6">
                <h3 class="m0"><img src="../img/brush_icon.jpg"> Top Artist</h3>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <h5><a href="#"> View All</a></h5>
            </div>
            
        </div>

         

    </div>

    <div class="col-md-4 col-sm-4 col-xs-12">

        <div class="col-md-12 col-sm-12 col-xs-12 right_part">
            <div class="user_image_in">
                <img src="../img/portfolio1.jpg" class="img-responsive" width="150">
            </div>

            <h2>Name here</h2>
            <h3>Tattoo, sketch, painiting etc</h3>
            <hr>
            <h4>ABC tattooz</h4>
            <h5>9A & 12, Hauz Khas Village, New Delhi</h5>
            <h1>011 33105944, 84688888888</h1>
            <h5>www.abctattoz.com</h5>


            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.0669913102!2d77.24097299999998!3d28.56775099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce3b2aef30497%3A0xde1236c2b20e22af!2s3C&#39;s!5e0!3m2!1sen!2sin!4v1429784670826" width="100%" height="150" frameborder="0" style="border:0"></iframe>



            <hr>

            <div class="text-left">Cast <img src="../img/cast_icon.png"></div>
            <p class="text-left">Rs. 1500 first inch 500 other inches</p>

            <div class="text-left"><a href="#" class="btn btn-default ">Booking Now</a></div>

        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 top_artist">

            <div class="col-md-6 col-sm-6 col-xs-6">
                <h3 class="m0"><img src="../img/brush_icon.jpg"> Top Artist</h3>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <h5><a href="#"> View All</a></h5>
            </div>
            
        </div>
    </div>
</div> 
<script>
    $(document).ready(function(){
        $("[rel^='lightbox']").prettyPhoto();
    });
</script>
