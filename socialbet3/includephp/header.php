<!DOCTYPE html>
<html>
<head>
	<title>page 1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

	<link href="stylesheets/main.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/lib/jquery-1.11.1.min.js"></script>
	<script src="js/lib/modernizr.custom.js"></script>
	<script type="text/javascript" src="js/lib/selectivizr-min.js"></script>
	<script type="text/javascript" src="js/lib/icheck.min.js"></script>
	<script src="js/lib/tcal.js"></script>
	<!--[if (gte IE 6)&(lte IE 8)]>
	  <script type="text/javascript" src="js/lib/selectivizr-min.js"></script>
	  <noscript><link rel="stylesheet" href="stylesheets/main.css" /></noscript>
	<![endif]-->
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
</head>
<body>
	<div class="content-wrapper">
		<!-- Left Sidebar -->
		<div class="left-sidebar">
			<!-- Logo -->
			<div class="logo-wrapper only-mob-hide">
				<a href=""><img src="images/logo.jpg"></a>
			</div>
			<!-- End of logo -->
			<div class="left-navbar-wrapper brand-blue-bg">
				<?php if (strpos($_SERVER['PHP_SELF'], 'index.php')===false) {?>
				<div class="mob-toggle">
					<div class="toggle-box">
						<label class="switch-light switch-ios" style="width: 100px" onclick="">
				        	<input type="checkbox">
			        		<span>
			            	&nbsp;
			            		<span>Профи</span>
					            <span>Любитель</span>
			          		</span>
				         	<a></a>
			        	</label>
					</div>
				</div>
				<?php } ?>
				<ul id="red" class="treeview-red treeview">
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-star"></span>
							<span>Избранное</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-football"></span>
							<span><a href="/soccer-bates.php">Футбол</a></span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-tennis"></span>
							<span>Теннис</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-hockey"></span>
							<span>Хоккей</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-basketball"></span>
							<span>Баскетбол</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-ball"></span>
							<span>Бильярд</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-biathlon"></span>
							<span>Биатлон</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-triathlon"></span>
							<span>Триатлон</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-handball"></span>
							<span>Гандбол</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-waterpolo"></span>
							<span>Водное поло</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-voleyball"></span>
							<span>Волейбол</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-diving"></span>
							<span>Плаванье</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-boxing"></span>
							<span>Бокс</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- Top nav -->
					<li class="expandable lvl-1">
						<div class="hitarea expandable-hitarea "></div>
						<span rel="link-text" class="">
							<span class="icon-judo"></span>
							<span>Борьба</span>
						</span>
						<!-- Sub nav 1 -->
						<ul class="lvl-2" style="display: none;">
							<li class="expandable">
								<div class="hitarea expandable-hitarea "></div>
								<span rel="link-text2">Россия</span>
								<!-- Sub sub nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="last">
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
										<span rel="link-text3"><a href="">Item 1.0.0</a></span>
									</li>
								</ul>
							</li>
							<!-- Sub nav 1 -->
							<li>
								<span rel="link-text2">Канада</span>
							</li>
							<li class="expandable lastExpandable">
								<div class="hitarea expandable-hitarea lastExpandable-hitarea "></div>
								<span rel="link-text2">Англия</span>
								<!-- Sub sub Nav -->
								<ul class="lvl-3" style="display: none;">
									<li class="expandable">
										<div class="hitarea expandable-hitarea "></div>
										<span rel="link-text3"><a href="">Чемпионат1</a></span>
										<span rel="link-text3"><a href="">Чемпионат2</a></span>
										<span rel="link-text3"><a href="">Длинное название чемпионата</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>

				</ul>
			</div>
		</div>
		<div class="content-sub-wrapper">
			<!-- End of left Sidebar -->
			<div class="left-gutter only-mob-hide">&nbsp;</div>
			<!-- Right top container -->
			<div class="right-top-container">
				<!-- Top navigation -->
				<div class="top-navigation-wrapper">
					<span class="icon-burgerbutton mob-nav"></span>
					<div class="left-nav-box pos-rel">
						<ul>
							<li class="t-d-view mob-view">
								<a onClick="return true" href="" class="mob-head mob-view">разделы<span class="icon-arrowdropdown"></span></a>
								<ul>
									<li><a href="">Главная</a></li>
									<li><a href="">Букмкеры</a></li>
									<li><a href="">Конкурсы</a></li>
									<li><a href="">Люди</a></li>
									<li><a href="">группы</a></li>
									<li><a href="">Блог</a></li>
								</ul>
							</li>
						</ul>
						
					</div>
					<div class="search-box t-d-view">
						<form methpd="post" action="/">
							<input type="text">
							<button type="submit" class="search-button"><span class="icon-search"></span></button>
						</form>
					</div>

					<div class="toggle-box only-mob-hide">
						<?php if (strpos($_SERVER['PHP_SELF'], 'index.php')===false) {?>
						<label class="switch-light switch-ios" style="width: 100px" onclick="">
				        	<input type="checkbox">
			        		<span>
			            	&nbsp;
			            		<span>Профи</span>
					            <span>Любитель</span>
			          		</span>
				         	<a></a>
			        	</label>
			        	<?php } ?>
					</div>

					<div class="top-right-nav">
						<ul>
							<?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) {?>
							<li class="fr"><a><span class="icon-enter md-trigger" data-modal="modal-4"></span></a></li>
							<?php } 
							else {	?>
							<li class="selected pos-rel"><a href=""><span class="icon-profile"></span></a>
								<div class="notification-counter"><span>12</span></div>
							</li>
							<li><a href=""><span class="icon-message"></span></a></li>
							<li><a href=""><span class="icon-notifications"></span></a></li>
							<li><a href=""><span class="icon-settings"></span></a></li>
							<li><a href=""><span class="icon-exit"></span></a></li>
							<?php } ?>

							
						</ul>
					</div>
					<div class="search-button md-trigger tab-por-view mob-view" data-modal="modal-1"><span class="icon-search"></span></div>
				</div>
				<!-- End of top navigation -->
			</div>
			<!-- End of Right top Container -->
			<!-- Main Container -->
			<div class="main-container<?php if (strpos($_SERVER['PHP_SELF'], 'soccer-bates.php') || strpos($_SERVER['PHP_SELF'], 'market-selection.php')) echo ' bates';?>">
			
