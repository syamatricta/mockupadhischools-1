<?php page_heading('Testimonials', 'banner-testimonials');?>
<section class="testimonial">
	<div class="container text-center">
		<h2>What Students Say</h2>
		<div class="row">
			<div class="col-md-12">
				 <div id="testimonial_view" class="owl-carousel">
				 	<?php foreach ($testimonials as $key => $testimonial) {?>
						 <div class="item">
						 	<div class="content" >
                                                            <div class="row">
                                                                <i class="fa fa-quote-left col-xs-1 margin40"></i>
                                                                <div class="col-xs-10">
                                                                    <?php /*strip_tags*/
                                                                    echo  $testimonial['testimonial'] ?>
                                                                </div>
                                                                <i class="fa fa-quote-right col-xs-1 margin40"></i>
                                                            </div>
						 	</div>
						 	<p class="name"><?php echo $testimonial['testimonial_name'];?></p>
						 </div>
					<?php } ?>
				 </div> 
			</div>
		</div>
	</div>
</section>
<!--
<section class="testimonial_content">	
	<div class="container">
		<div class="">
			<h2>We make the course material interesting by imparting real life examples.</h2>
			<p class="type1">Our instructors are able to achieve results other real estate education companies can only dream of.</p>
			<p class="mtop50">Since 2003, Adhi Schools has helped students not only pass the examination but also build a career in real estate.</p>
			<p>We are invested in the success of our students.If you succeed, then we succeed.</p>
			<p class="mtop50">Just take a look at where we hold our classes-inside of the largest names in real estate brokerage on the planet.</p>
			<p>These companies rely on us to provide real estate education services to their new agents.We won't let them or our students down </p>
		</div>
		<div class="line"></div>
	</div>
</section>
-->