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
				<img id="portrait" src="./photos/ryan-albrecht-2015.jpg" alt="portrait of Ryan Albrecht"/>
				<p>
					My name is <em>Ryan Albrecht</em>. I create web applications and solve problems.
					You can find me in <em>San Francisco</em>.
				</p>
			</section>

			<section id="contact-info">
				<h1>How to get in touch</h1>
				<dl>
					<dt>Email</dt>
					<dd><a href="mailto:hello@ryanalbrecht.ca" rel="me" title="My Email"><em>hello@ryanalbrecht.ca</em></a></dd>

					<dt>Other Places</dt>
					<dd class="half"><a rel="me" href="https://github.com/ryan953" title="GitHub projects"><em>GitHub</em></a></dd>
					<dd class="half"><a rel="me" href="http://ca.linkedin.com/in/ryanalbrecht" title="LinkedIn profile"><em>LinkedIn</em></a></dd>
					<dd class="half"><a rel="me" href="http://stackoverflow.com/users/98206/ryan953" title="StackOverflow profile"><em>Stack Overflow</em></a></dd>
				</dl>
			</section>

			<section id="projects">
				<section id="apps">
					<h1>On The Web</h1>
					<ul>
						<li>
							<a href="https://medium.com/@Pinterest_Engineering/introducing-bonsai-an-open-source-webpack-analyzer-6bdfe22f8984">Introducing Bonsai Webpack Analyzer</a>
							<small>(<a href="https://github.com/pinterest/bonsai/">github</a>)</small>
						</li>
						<li>
							<a href="https://github.com/ryan953/ryanalbrecht.ca/blob/master/blog/react-howto.md">
								How to simply use React.js
							</a>
						</li>
						<li>
							<a href="https://code.facebook.com/posts/964122680272229/web-performance-cache-efficiency-exercise/">
								Web performance: Cache efficiency exercise
							</a>
						</li>
						<li><a href="//apps.ryan953.com/sets">Sets! Card Game</a></li>
						<li>
							<a href="https://mapmap.ryan953.com/">Map Map</a>
							<small>(<a href="https://github.com/ryan953/mapmap">github</a>)</small>
						</li>
						<li>
							<a href="https://www.npmjs.com/package/flow-annotation-check">flow-annotation-check</a>
							<small>(<a href="https://github.com/ryan953/flow-annotation-check">github</a>)</small>
						</li>
						<li>
							<a href="https://www.npmjs.com/package/Enumjs">Enumjs</a>
							<small>(<a href="https://github.com/ryan953/Enumjs">github</a>)</small>
						</li>
						<li>
							<a href="//apps.ryan953.com/color/">Color format</a>
							<small>
								(<a href="//apps.ryan953.com/color/test.html">tests</a>,
								<a href="https://github.com/ryan953/color">github</a>)
							</small>
						</li>
						<li>
							<a href="//apps.ryan953.com/guiders">Guiders 'new user experience' tooltips</a>
							<small>(<a href="https://github.com/ryan953/GuidedTasks">github</a>)</small>
						</li>
						<li><a href="https://github.com/ryan953/JS-Template">A simple javascript templating class</a></li>
						<li>
							<a href="//apps.ryan953.com/CSSOFF2011/HTML/">CSS Off! submission</a>
							<small>(<a href="http://www.unmatchedstyle.com/cssoff/">via unmatchedstyle.com</a>)</small>
						</li>
						<li><a href="//apps.ryan953.com/computational_math">Computational Math Algorithms Implemented in JavaScript</a></li>
					</ul>
				</section>
			</section>

			<?php include('books.php'); ?>
			<!--
			<section id="books">
				<section id="my-shelf">
					<h1>Tech-Related Books I've Read</h1>
					<ul>
						<?php echo getBookList(books(), true); ?>
					</ul>
				</section>
				<section id="wish-list">
					<h1 class="toggler">My Wish List</h1>
					<ul>
						<?php echo getBookList(books(), false); ?>
					</ul>
				</section>
			</section>
			-->

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
