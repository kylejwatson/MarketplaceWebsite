<!DOCTYPE html>
<html lang="en">
<head>
	<title> Kyle Watson's Portfolio - Personal </title>
	<meta charset="UTF-8" />
	<meta name="keywords" content="Portfolio, Student, Developer, Counter-Strike">
	<meta name="description" content="A simple portfolio to show off projects and attributes.">
	<meta name="author" content="Kyle Watson">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<!--Font Awesome by Dave Gandy - http://fontawesome.io-->
	<!-- <i> tags used for glyphicons (styling) so technically incorrect use of HTML but hidden from accessibility with "aria-hidden=true" attribute-->
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="script.js"></script>
</head>
<body>
	<header id="branding">
		<h1 class="row col-12">Personal Bio</h1>
		<nav id="navigation">
			<h2> Navigation </h2>
			<ul class="row">
				<li class="col-3"><a href="index.php"><span class="fa fa-home" aria-hidden="true"></span> Home </a></li>
				<li class="col-3"><a href="personal.php"><span class="fa fa-user" aria-hidden="true"></span> Personal Bio </a></li>
				<li class="title-nested col-3"><a href="projects/"><span class="fa fa-code" aria-hidden="true"></span> Projects </a>
					<ul class="nested-list">
						<li><a href="projects/project1/"> <abbr title="Universal Serial Bus">USB</abbr> Backup </a></li>
						<li><a href="projects/project2/"> <abbr title="Grand Theft Auto">GTA</abbr> Graphics Fix </a></li>
						<li><a> More Coming Soon! </a></li>
					</ul>
				</li>
				<li class="col-3"><a href="contact.php"><span class="fa fa-address-book" aria-hidden="true"></span> Contact me </a></li>
			</ul>
		</nav>
	</header>
	<aside class="aside-3">
		<h2> Personal Overview</h2>
		<p> This Section gives a general overview of my personality, including:</p>
		<ul>
			<li ><a href="#interests">Interests <span class="fa fa-arrow-circle-up" aria-hidden="true"></span></a></li>
			<li><a href="#timetable">Timetable <span class="fa fa-arrow-circle-up" aria-hidden="true"></span></a></li>
			<li><a href="#photo">Photo <span class="fa fa-arrow-circle-up" aria-hidden="true"></span></a></li>
		</ul>
	</aside>
	<main id="bio" tabindex="-1">
		<!-- Content starts here -->
		<section id="interests">
			<h3><span class="fa fa-gamepad" aria-hidden="true"></span> Interests </h3>
			<p>
				My interests range from computer gaming including professional <abbr title="Electronic Sports">E-Sports</abbr> to <abbr title="Disc Jocky"> DJ</abbr>-ing and music production.
				I follow professional E-Sports teams in different games like <a href="http://www.fnatic.com/" target="_blank" title="opens new window">Fnatic</a> who play <a href="http://blog.dota2.com/" target="_blank" title="opens new window">
				<abbr title="Defense of the Ancients">Dota</abbr> 2</a>, <a href="https://nip.gl/" target="_blank"  title="opens new window"><abbr title="Ninjas in Pyjamas">NiP</abbr></a> who play <a href="http://blog.counter-strike.net/" target="_blank" title="opens new window">
				<abbr title="Counter Strike: Global Offensive">CS:GO</abbr></a>.
			</p>
			<figure>
				<img src="images/csgo2.jpg" height="225" width="400" alt="A screen shot of a conflict in CS:GO"/>
				<figcaption>
					This shows a firefight occurring mid-game on the map Inferno.
				</figcaption>
			</figure>
		</section>
		<section id="timetable">
			<h3><span class="fa fa-calendar" aria-hidden="true"></span> Timetable</h3>
			<p>
				There are many modules in my uni course, here is a list of there descriptions as well as my contact hours.
			</p>
			<dl>
				<dt>PD+P</dt>
				<dd>Professional development and practices is a module that focuses on becoming a professional developer that understands how laws are applicable to their work, being able to manage a project as well as helping with study skills.</dd>
				<dt> WebDevHCI</dt>
				<dd>Web Development and Human Computer interfaces is all about <abbr title="Hyper Text Markup Language 5"><a href="https://en.wikipedia.org/wiki/HTML5" target="_blank" title="opens new window">HTML5</a></abbr> and <abbr title="Cascading Style Sheets"><a href="https://en.wikipedia.org/wiki/Cascading_Style_Sheets" target="_blank" title="opens new window">CSS</a></abbr> and how to <em>correctly write it to the proper standards</em> as well as learning how to create intuitive <abbr title="User Interface">UI</abbr> designs and understanding how websites can be more accessible using these designs. </dd>
				<dt> DBS </dt>
				<dd>Database Systems is a module focussing on the creation and use of databases through <abbr title="Structured Query Language">SQL </abbr>and the theory for making correct useful models.</dd>
				<dt>Programming</dt>
				<dd>Programming focusses on learning the fundamentals of an object-oriented language through learning how to use Java correctly and following correct conventions.</dd>
				<dt>CSI-Linux</dt>
				<dd>Computer System Internals and Linux is a module split into learning about the fundamentals of computers such as there hardware and binary manipulation, as well as a section on learning how to use the <abbr title="Command Line Interface">CLI</abbr> of Linux Distros correctly and efficiently.</dd>
			</dl>
			<p id="table-popup">
				<a href="table-popup.php" target="_blank" title="opens new window">View Timetable</a>
			</p>
			<table class="primary" title="Timetable">
				<caption> University Contact Hours </caption>
				<thead>
					<tr>
						<th id="days"> Days </th>
						<th id="nine"> 9:00-9:50 </th>
						<th id="ten"> 10:00-10:50</th>
						<th id="eleven"> 11:00-11:50</th>
						<th id="twelve"> 12:00-12:50</th>
						<th id="one"> 13:00-13:50</th>
						<th id="two"> 14:00-14:50</th>
						<th id="three"> 15:00-15:50</th>
						<th id="four"> 16:00-16:50</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th id="mon" headers="days"> Monday </th>
						<td headers="mon nine"></td>
						<td headers="mon ten"></td>
						<td headers="mon eleven">DBS Lecture with CBryant in Chapman3 </td>
						<td headers="mon twelve">PD+P Lecture with AYoung in Chapman3 </td>
						<td headers="mon one">DBS Lecture with CBryant in Chapman3 </td>
						<td headers="mon two"></td>
						<td headers="mon three"></td>
						<td headers="mon four"></td>
					</tr>
					<tr>
						<th id="tue" headers="days"> Tuesday</th>
						<td headers="tue nine"></td>
						<td headers="tue ten"></td>
						<td headers="tue eleven">Programming Workshop with AAkinbi and DNewton in Newton140</td>
						<td headers="tue twelve"></td>
						<td headers="tue one">Programming Lecture with DNewton in Chapman6</td>
						<td headers="tue two"></td>
						<td headers="tue three">CSI-Linux Workshop with NMurray in Newton242</td>
						<td headers="tue four"></td>
					</tr>
					<tr>
						<th id="wed" headers="days">Wednesday</th>
						<td headers="wed nine"></td>
						<td headers="wed ten">PD+P Lecture with AYoung in Chapman3</td>
						<td headers="wed eleven">Programming Lecture with DNewton in Newton140</td>
						<td headers="wed twelve">CSI-Linux Lecture with NMurray in Chapman5</td>
						<td headers="wed one"></td>
						<td headers="wed two"></td>
						<td headers="wed three"></td>
						<td headers="wed four"></td>
					</tr>
					<tr>
						<th id="thu" headers="days">Thursday</th>
						<td headers="thu nine">Programming Workshop with AAkinbi and DNewton in Newton140</td>
						<td headers="thu ten"></td>
						<td headers="thu eleven twelve" colspan="2">WebDevHCI Lecture with CHughes in Chapman2</td>
						<td headers="thu one">DBS Workshop/Lecture with AAkinbi and CBryant in Newton140</td>
						<td headers="thu two">WebDevHCI Workshop with CHughes in Newton141</td>
						<td headers="thu three"></td>
						<td headers="thu four">CSI-Linux Tutorial with NMurray in Newton236-237</td>
					</tr>
					<tr>
						<th id="fri" headers="days"><abbr title="Thank God It's Friday">TGIF!</abbr></th>
						<td headers="fri nine"></td>
						<td headers="fri ten"></td>
						<td headers="fri eleven">PD+P Tutorial with AYoung in Peel337</td>
						<td headers="fri twelve">WebDevHCI Workshop with CHughes in Newton141</td>
						<td headers="fri one"></td>
						<td headers="fri two"></td>
						<td headers="fri three"></td>
						<td headers="fri four"></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th id="mirror" colspan="9"> This timetable was last mirrored on Friday 14th October 2016 </th>
					</tr>
				</tfoot>
			</table>
		</section>
		<section id="photo">
			<h3><span class="fa fa-photo" aria-hidden="true"></span> Handsome Photo </h3>
			<figure>
				<img src="images/selfie-s.jpg" height="384" width="216" alt="A selfie of my face." />
				<figcaption>
					And here is my fabulous face in <em>all</em> of its glory.
				</figcaption>
			</figure>
		</section>
		<!-- Content ends here -->
	</main>
	<footer id="contact">
		<address>
			Created by some <a href="mailto:k.j.watson1@edu.salford.ac.uk">guy.</a>
		</address>
		<p>
			<?php
				echo "Last Modified: " . date("d/m/y H:m",filemtime(__FILE__));
			?>
		</p>
		<nav id="bottom-nav">
			<p>
				<a href="#branding"><span class="fa fa-arrow-circle-up" aria-hidden="true"></span> Back to the top.</a>
			</p>
		</nav>
	</footer>
</body>
</html>
