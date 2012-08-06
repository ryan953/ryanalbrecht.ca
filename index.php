<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>ryanalbrecht.ca</title>

	<link rel="stylesheet" type="text/css" href="./all.css" />

	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-20543648-1']);
		_gaq.push(['_trackPageview']);
		_gaq.push(['_trackPageLoadTime();']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>
<body>

	<div class="wrapper civilization">
		<div class="content">

			<section id="introduction">
				<h1>Hi there</h1>
				<img id="portrait" src="./ryan-albrecht.jpg" alt="portrait of Ryan Albrecht"/>
				<p>
					My name is <em>Ryan Albrecht</em>. I create web applications and solve problems.
					You can find me in <em>Toronto</em>.
				</p>
			</section>

			<section id="contact-info">
				<h1>How to get in touch</h1>
				<dl>
					<dt>Email/MSN/GTalk</dt>
					<dd><a href="mailto:ryan@ryanalbrecht.ca" rel="me" title="My Email"><em>ryan@ryanalbrecht.ca</em></a></dd>

					<dt>Resume/CV</dt>
					<dd>
						<a href="albrecht_ryan_resume.html" title="My Resume"><em>HTML</em></a>
						or
						<a href="albrecht_ryan_resume.pdf" title="My Resume"><em>PDF</em></a>
					</dd>

					<dt>Other Places</dt>
					<dd class="half"><a rel="me" href="http://www.freshbooks.com/team/ryan" title="My job working at FreshBooks"><em>FreshBooks</em></a></dd>
					<dd class="half"><a rel="me" href="https://plus.google.com/100893252150236411014" title="Google Plus profile"><em>Google+</em></a></dd>
					<dd class="half"><a rel="me" href="http://twitter.com/ryan953" title="Twitter profile"><em>Twitter</em></a></dd>
					<dd class="half"><a rel="me" href="https://github.com/ryan953" title="GitHub projects"><em>GitHub</em></a></dd>
					<dd class="half"><a rel="me" href="http://ca.linkedin.com/in/ryanalbrecht" title="LinkedIn profile"><em>LinkedIn</em></a></dd>
					<dd class="half"><a rel="me" href="http://stackoverflow.com/users/98206/ryan953" title="StackOverflow profile"><em>Stack Overflow</em></a></dd>
				</dl>
			</section>

			<section id="projects">
				<section id="apps">
					<h1>On The Web</h1>
					<ul>
						<li><a href="//apps.ryan953.com/sets">Sets! Card Game</a></li>
						<li><a href="//andthatisafact.com">And That Is A Fact</a></li>
						<li><a href="//bierfrau.com">Bier Frau</a></li>
						<li><a href="//apps.ryan953.com/link_map2">JavaScript Link Map</a></li>
						<li><a href="//apps.ryan953.com/computational_math">Computational Math Algorithms Implemented in JavaScript</a></li>
					</ul>
				</section>

				<section id="scripts">
					<h1>To Download</h1>
					<ul>
						<li><a href="https://github.com/ryan953/JS-Template">A simple javascript templating class</a></li>
						<li><a href="//apps.ryan953.com/src/fixVideoFiles.bash">Add .avi files to your iTunes library (needs Xcode)</a></li>
					</ul>
				</section>
			</section>

			<?php include('books.php'); ?>

			<section id="books">
				<section id="my-shelf">
					<h1>Tech-Related Books I've Read</h1>
					<ul>
						<?php echo getBookList(books(), true); ?>
					</ul>
				</section>
				<!--<section id="wish-list">
					<h1 class="toggler">My Wish List</h1>
					<ul>
						<?php echo getBookList(books(), false); ?>
					</ul>
				</section>-->
			</section>

			<?php
			$width = '720px';
			$height = '500px';
			?>

			<!--
			<div class="stacked" id="map" style="width:<?php echo $width ?>; height:<?php echo $height ?>;">
				<canvas class="background" width="<?php echo $width ?>" height="<?php echo $height ?>"></canvas>
				<div class="overlay"></div>
			</div>
			-->
		</div>
	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<!--
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script src="http://www.google.ca/reader/ui/publisher-en.js"></script>

	<script src="./nodes.json" type="text/javascript"></script>
	<script src="./links.json" type="text/javascript"></script>

	<script src="./defaults.js"></script>
	<script src="./template.js"></script>
	<script src="./link-map.js"></script>

	<script>
	$(document).ready(function() {
		/*map.clear();
		map.nodes = nodes;
		map.links = links;
		map.draw();*/
	});
	</script>
	-->

	<script>
	$(document).ready(function() {
			$('a[href]').click(function() {
					_gaq.push(['_trackEvent', 'links', 'clicked', $(this).attr('href')]);
			});
	});
	</script>

</body>
</html>
