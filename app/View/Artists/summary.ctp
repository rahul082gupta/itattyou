<?php 
    echo $this->Html->css(array('main'));
?>
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
                <div class="follow_numbers follow_count">
                <?php 
                    echo count($this->request->data['ArtistFollower']);
                ?>
            </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="follow">Following</div>
                <div class="follow_numbers"><?php echo count($this->request->data['ArtistFollowing']);?></div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="follow">Project Views</div>
                <div class="follow_numbers">15520</div>

            </div>
        </div> 


        <div class="col-md-12 col-sm-12 col-xs-12 left_lower">
            <h2 class="h2_ds">Artist Bio</h2>
            <p><?php echo $this->request->data['Artist']['about']; ?> </p>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-edit"></i> Edit
            </button>

            <!-- Modal -->
            <?php 
            echo $this->Form->create('Artist', array(
                            'inputDefaults' => array(
                                'label' => false,
                                'div'   => false
                            ),
                            'class' => 'validationengine',
                            'action' => 'summary'
                        )
                    );
                    ?>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Artist Bio</h4>
                  </div>
                  <div class="modal-body">
                    
                     <?php
                        echo $this->Form->hidden('Artist.id');
                       
                        echo $this->Form->input('Artist.about', array('placeholder' => 'About You', 'type' => 'textarea', 'cols' => '78', 'rows' => '20'));
                    ?>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Save changes</button>
                  </div>
                </div>
              </div>
            </div>

            <?php echo $this->Form->end();?>
            <br><br><br>
            <h2 class="h2_ds">Artist Profile</h2>

            <ul class="thumbnails">
                 <div class="">
                    <?php if($this->request->data['ArtistArt']) {

                            foreach($this->request->data['ArtistArt'] as $image) {
                     ?> 
                                <li class="col-md-2 col-sm-2 col-xs-12 p5 artist_profile" id="clients-edit-wrapper">
                                  
                                    <a class="thumbnail" rel="lightbox[group]" href="<?php echo $image['image']?>">
                                        <img class="group1" src="<?php echo $image['image']?>" title="Image Title" />
                                    </a>

                                    <button type="button" onclick="$('#clients-edit-wrapper').remove();" class="close_img" data-toggle="tooltip" data-placement="top" title="Delete this picture permanently"><span aria-hidden="true">×</span></button>

                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <?php if($this->request->data['ArtistVideo']) {

                        foreach($this->request->data['ArtistVideo'] as $video) {
                 ?>
                            <div class="col-md-4 col-sm-4 col-xs-4 p5">
                                <object width="100%" height="150" data="<?php echo $video['video'];?>">
                                 </object>
                                
                            </div>
                        <?php } 
                    } else { ?>
                        <li class="col-md-6 col-sm-6 col-xs-12 p5">
                            No Profile found.
                        </li>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 top_artist">

            <div class="col-md-6 col-sm-6 col-xs-6">
                <h3 class="m0"><?php echo $this->Html->image('brush_icon.jpg');?> Top Artist</h3>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <h5><a href="#"> View All</a></h5>
            </div>
            
        </div>

         

    </div>

    <div class="col-md-4 col-sm-4 col-xs-12">

        <div class="col-md-12 col-sm-12 col-xs-12 right_part">
            <div class="user_image_in">
                <?php 
                    if($this->request->data['Artist']['photo'] &&  strpos($this->request->data['Artist']['photo'], 'http')) {
                        echo $this->Html->image($this->request->data['Artist']['photo'], array('class' => 'img-responsive', 'width' => '150'));
                    }elseif($this->request->data['Artist']['photo']) {
                         echo $this->Html->image('/uploads/'.$this->request->data['Artist']['photo'], array('class' => 'img-responsive', 'width' => '150'));
                    }else {
                        
                        echo $this->Html->image('user_image.png', array('class' => 'img-responsive', 'width' => '150'));

                    }
                ?>
            </div>
            
            <h2 contenteditable="true"><?php echo $this->request->data['Artist']['name'];?> <i class="fa fa-chevron-circle-left" data-toggle="tooltip" data-placement="top" title="Click on Name to edit"></i></h2>
            <h3 contenteditable="true"><?php echo $this->request->data['Tatoo']['name'];?> <i class="fa fa-chevron-circle-left" data-toggle="tooltip" data-placement="top" title="Click on Name to edit"></i></h3>
            <hr>
            <h4 contenteditable="true"><?php echo $this->request->data['Artist']['studio'];?> <i class="fa fa-chevron-circle-left" data-toggle="tooltip" data-placement="top" title="Click on Name to edit"></i></h4>
            <h5 contenteditable="true"><?php echo $this->request->data['Artist']['address'];?> <i class="fa fa-chevron-circle-left" data-toggle="tooltip" data-placement="top" title="Click on address to edit"></i></h5>
            <h1 contenteditable="true"><?php echo $this->request->data['Artist']['contact'];?> <i class="fa fa-chevron-circle-left" data-toggle="tooltip" data-placement="top" title="Click on contact number to edit"></i></h1>
            <h5 contenteditable="true"><?php echo $this->request->data['Artist']['website'];?> <i class="fa fa-chevron-circle-left" data-toggle="tooltip" data-placement="top" title="Click on website name to edit"></i> </h5>
            <iframe width="100%" height="150"  frameborder="0" style="border:0"
          src="https://www.google.com/maps/embed/v1/place?key=<?php echo GOOGLE_API_KEY;?>
            &q=<?php echo $this->request->data['Artist']['address'] ?>" >
            </iframe>

            <hr>

            <div class="text-left">Cast 
                <?php echo $this->Html->image('cast_icon.png');?>
            </div>
            <p class="text-left">Rs. 1500 first inch 500 other inches</p>

            <div class="text-left"><a href="#" class="btn btn-default ">Booking Now</a></div>

        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 top_artist">

            <div class="col-md-6 col-sm-6 col-xs-6">
                <h3 class="m0"><?php echo $this->Html->image('brush_icon.jpg');?> Top Artist</h3>
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
         $('[data-toggle="tooltip"]').tooltip();
        

    });
    
</script>

