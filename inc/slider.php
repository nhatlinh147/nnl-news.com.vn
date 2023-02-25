<?php include 'classes/slider.php';?>
<?php $slider = new slider(); ?>


<div id="demo" class="carousel slide" data-ride="carousel" style="margin: 0px 2px;">
	<!-- Indicators -->
	<ul class="carousel-indicators">
		<li data-target="#demo" data-slide-to="0" class="active"></li>
		<li data-target="#demo" data-slide-to="1"></li>
		<li data-target="#demo" data-slide-to="2"></li>
	</ul>
  
	<!-- The slideshow -->
	<div class="carousel-inner">
		<?php
			$show_slide = $slider->show_slider(0,3);
			 if($show_slide){
		                $i = 0;
		                while($result = $show_slide->fetch_assoc()){
		                $i++;
		?>
		<div class="carousel-item <?php $str = $i == 1 ? 'active' : ''; echo $str; ?>">
			<div class="hero__item set-bg" data-setbg="Admin/upload/<?php echo $result['Slide_Image'] ?>">
			   <!--  <div class="hero__text">
			        <h2><?php echo $result['Slide_Title'] ?></h2>
			        <p><?php echo $result['Slide_Desc'] ?></p>
			        <a href="#" class="primary-btn">SHOP NOW</a>
			    </div> -->
			</div>
		</div>
		<?php
                }
            }
        ?>
		
	</div>
</div>