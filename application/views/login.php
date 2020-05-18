<div id="loginarea">

	<div class="container">
	
		<div id="loginbox">
	
			<h2>Engineer Login</h2>

			<span style="color:#ff0000;">
			<?php
			if (validation_errors()) {
				echo nl2br(validation_errors());
			}
			?>
			</span>
			<?php echo form_open('login'); ?>
			<input type="text" id="username" name="username" placeholder="Username" />
			<br/>
			<input type="password" id="password" name="password" placeholder="Password" />
			<br/>
			<input type="submit" value="" /><br/>
			<?php echo anchor('login/register', 'Don\'t have an account? Sign Up Now', 'class="register"'); ?>
			</form>

		</div>
		
		<div id="lightbulb"></div>
		
		<div class="clear: both;"></div>
	
	</div>

</div>

<div class="container" style="margin-top: 30px;margin-bottom: 20px;">

	<div class="halfbox left">

		<div class="halfboxcontainer">
	
			<div class="title">
		
				<h2 style="padding-right: 190px;">We Are Here To Serve You</h2>
				<div class="title-sep">
					<div class="title-sep-lines">
					</div>
				</div>
		
			</div>
			
			NEUTEX LED Lighting was established to foster the growth, pioneer advances and innovation in the research and development, manufacturing, distribution, service and supply of advanced, energy efficient, eco-responsible LED lighting products. By enabling themselves as the partner of choice, they comprehend the energy saving needs of government, industry and enterprise.<br/><br/><br/>
			
			<ul class="serve">
			
				<li class="phone">281.227.2208</li>
				<li class="email">info@neutexworld.com</li>
				<li class="location">Houston, TX 77032</li>
			
			</ul>
	
		</div>

	</div>
	
	<div class="halfbox right">

		<div class="halfboxcontainer">
	
			<div class="title">
		
				<h2 style="padding-right: 50px;">Our Workplace</h2>
				<div class="title-sep">
					<div class="title-sep-lines">
					</div>
				</div>
		
			</div>
			
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3457.112761661415!2d-95.3138309!3d29.947435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640b6b271f9d95f%3A0xc86105a6ebfcff7c!2s15700+Vickery+Dr%2C+Houston%2C+TX+77032!5e0!3m2!1sen!2sus!4v1431454582892" width="100%" height="200" frameborder="0" style="border:0"></iframe>
	
		</div>

	</div>
	
	<div class="clear"></div>

</div>

<div class="container">

	<div class="title">

		<h2>Members Of</h2>
		<div class="title-sep">
			<div class="title-sep-lines">
			</div>
		</div>
	
		<div class="clear"></div>
	
	</div>
	
	<div class="membersof">

		<img src="/images/logos/GHP-logo.jpg" title="GHP" />
		<img src="/images/logos/NAM-Logo.jpg" title="NAM" />
		<img src="/images/logos/PRSM-Logo.jpg" title="PRSM" />
		<img src="/images/logos/TEMA-logo.jpg" title="TEMA" />
		<img src="/images/logos/bbb.png" title="BBB" />
	
	</div>

</div>