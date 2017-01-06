 <?php  get_header (); ?>
			
			<div id="content">
			
				<div id="inner-content" class="row">
			
				    <div id="main" class="large-10 medium-10 small-centered columns" role="main">
				    <div id="myelement">
					 	<section>
					 		<h1>Said El aoumari</h1>
					 		<h2>Intégrateur / Développeur Web</h2>
					 		<p>HTML - CSS - Javascript - jQuery</p>
					 		<ul>
					 			<li>https://github.com/saideloumari</li>
					 			<li>said.elaoumarii@gmail.com</li>
					 			<li>Linkedin : Said El aoumari</li>
					 			<li>06 16 43 50 95</li>
					 			<a href="http://a183431562.testurl.ws/cv.pdf">Télécharger et/ou Voir mon CV</a>
					 		</ul>
							<p>Intégrateur Front-end, je suis spécialisé dans la conception de sites web et dans la programmation d’interfaces.
							Je suis actuellement en poste au sein de l'association <a href="http://lepoles.org">LepoleS (92)</a>.
							Ce site présente mon CV d’intégrateur front-end. En le parcourant, vous pourrez avoir accès à mes réalisations, à mes expériences professionnelles ou encore à mes compétences.
							Vous pouvez me retrouver aussi sur Linkedin.
							Je vous souhaite une agréable visite.</p>
					 		<a href="/#porfolio"><img src="<?php echo site_url() ?>/wp-content/themes/bakedwp/assets/images/fleche.png" alt="" /></a>

					 	</section>
					 </div>
					 	<section id="porfolio">
					 		<h3 >portfolio</h3>
					 		<p>Dans cette section vous pourrez trouver en images mes différentes réalisations ou/et les différents projets auxquels j'ai pu participer avec les descriptions de mes contributions</p>
								<?php echo do_shortcode("[foogallery id='54']");  ?>
					 		
					 	</section>
					 	<section id="propos">
					 		<h3 >à propos</h3>
					 		<div  class="diplomeun">
					 			<p>Dans cette section vous trouverez les différents diplômes que j'ai obtenus </p>
					 			<h5>Diplômes : Intégrateur/Développeur web</h5>
					 			<ul>
					 				<li>2015/2016 - obtention des certifications développeur et intégrateur web (Niveau IV)</li>
					 			</ul>
					 		</div>
					 		<div class="diplomedeux">
					 			<h5>Diplômes : BEP Electrotechnique</h5>
					 			<ul>
					 				<li>2010/2011 - obtention BEP</li>
					 			</ul>
					 		</div>

					 		<div id="competances">
					 			<h3 >mes compétences</h3>
					 			<ul>
					 				<p>FRONT-END :</p>
					 				<li>HTML5</li>
					 				<li>CCS3</li>
					 				<li>JavaScript</li>
					 				<li>JQuery</li>
					 			</ul>
					 			<ul>
									<p>BACK-END :</p>
					 				<li>Ajax</li>
					 				<li>PHP</li>
					 				<li>MySQL</li>
					 			</ul>
					 			<ul>
					 				<p>LOGICIEL :</p>
					 				<li>Word</li>
					 				<li>Excel</li>
					 				<li>Photoshop</li>
					 				<li>InDesign</li>
					 			</ul>
					 			<ul>
					 				<p>OUTILS COLLABORATIFS :</p>
					 				<li>Meistertask</li>
					 				<li>Github</li>
					 				<li> </li>
					 				<li> </li>
					 			</ul>
					 		</div>

					 	</section>
					 	<section>
					 	<div id="ElementDeux">
					 		<h3>Contact</h3>
					 		<p>Vous pouvez me contacter via ce formulaire ou par téléphone au 06 16 43 50 95</p>
					 		<?php echo do_shortcode("[contact-form-7 id='19' title='Formulaire de contact 1']");  ?>
					 		<iframe width="100%" height="300px" frameBorder="0" src="https://umap.openstreetmap.fr/fr/map/carte-sans-nom_116960?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&allowEdit=false&moreControl=true&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=true&onLoadPanel=undefined&captionBar=false"></iframe><p><a href="https://umap.openstreetmap.fr/fr/map/carte-sans-nom_116960">Voir en plein écran</a></p>
					 	</section>
								
				    </div> <!-- end #main -->
    				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>
	</div>