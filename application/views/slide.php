<style type="text/css" media="screen">
  .carousel-inner>.item>img, .carousel-inner>.item>a>img{
        line-height: 1;
    height: 356px;
  }
</style>
<section id="banner-area" class="banner-area">
  <div class="container-fluid">
    <div class="row">
      <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
          <li data-target="#myCarousel" data-slide-to="4"></li>
          <li data-target="#myCarousel" data-slide-to="5"></li>
        </ol>
        
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active"> <img src="<?php echo base_url()?>assets/front/images/banner-17.jpg" alt=""> </div>
          <div class="item"> <img src="<?php echo base_url()?>assets/front/images/banner-9.jpg" alt=""> </div>
          <!--           <div class="item"> <img src="<?php echo base_url()?>assets/front/images/banner-10.jpg" alt=""> </div> -->
          <div class="item"> <img src="<?php echo base_url()?>assets/front/images/banner-7.jpg" alt=""> </div>
          <div class="item"> <img src="<?php echo base_url()?>assets/front/images/banner-1.jpg" alt=""> </div>
        </div>
        
        <!-- Left and right controls --> 
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
    </div>
  </div>
</section>