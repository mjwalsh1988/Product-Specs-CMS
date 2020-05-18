<div id="uni">
	<a href="https://www.neutexled.com/university">Neutex University</a>
</div>
<div id="footerlinks">

	<div class="container">
	
		<div class="footwidget">
		
			<br/><br/><img src="/images/footerlogo.png" title="Neutex" /><br/>
			15700 Vickery Dr.<br/>
			Houston, Texas 77032<br/>
			281.227.2208<br/>
			Mississippi: <a href="tel:6014011002">601.401.1002</a><br/>
			<a href="mailto:info@neutexworld.com">info@neutexworld.com</a>
		
		</div>
		
		<div class="footwidget">
		
			<ul>
				<li class="main">Lighting Solutions</li>
				<li><a href="http://neutexlighting.com/specialty-lighting">Commercial</a></li>
				<li><a href="http://neutexlighting.com/indoor">Residential</a></li>
				<li><a href="http://neutexlighting.com/industrial">Industrial</a></li>
				<li><a href="http://neutexlighting.com/garage/parking">Parking / Garage</a></li>
				
			</ul>
		
		</div>
		
		<div class="footwidget">
		
			<ul>
				<li class="main">Knowledge</li>
				<li><a href="http://neutexlighting.com/led-101">LED 101</a></li>
				<li><a href="http://neutexlighting.com/benefits-of-led">Benefits of LED</a></li>
				<li><a href="http://neutexlighting.com/optimize-with-led">Optimize with LED</a></li>
				<li><a href="http://neutexlighting.com/faqs">FAQs</a></li>
				
			</ul>
		
		</div>
		
		<div class="footwidget">
		
		
		
		</div>
		
		<div class="clear"></div>
		
	</div>

</div>
<div id="footer">

	<div class="container">
	
		Copyright 2015 Neutex | All Rights Reserved | Designed by <a href="http://getklicks.com/" target="_blank">GetKlicks</a>
		
	</div>

</div>
<?php echo form_open('home/newhome', array('id'=>'getItem')); ?>
<input type="hidden" name="family" id="postfamily" />
<input type="hidden" name="type" id="posttype" />
<input type="hidden" name="wattage" id="postwattage" />
<?php echo form_close(); ?>
	<ul id="familymenu">
	
	<?php
	foreach ($allSorted AS $familyid => $family) {
	
		echo"
		
			<li>
				<span class='family_click' data-fcid='".$familyid."'>".$family['label']."</span>
				<ul>
		
		";
		foreach ($family AS $typeid => $type) {
		
			if ($typeid == "label") continue;
			echo"
				<li><span class='type_click' data-fcid='".$typeid."'>".$type['label']."</span><ul>
			";
			//array_multisort($type, SORT_ASC, SORT_NUMERIC);
			foreach ($type AS $wattageid => $wattage) {
				if ($wattageid == "label") continue;
				echo"<li data-fcid='".$wattageid."' class='navwattage'>".$wattage['label']."</li>";
			}
			echo"</ul></li>";
		
		}
		echo"
		
				</ul>
			</li>
		
		";
	
	}
	?>
	
	</ul>

</body>
</html>