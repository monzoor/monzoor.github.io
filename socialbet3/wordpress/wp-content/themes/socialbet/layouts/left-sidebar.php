<?php
/**
 * Left sidebar template,
 * will use this in almost all pages
 *
 * @version 1.0
 */
?>

<div class="left-sidebar">
	<!-- Logo -->
	<div class="logo-wrapper only-mob-hide">
		<a href="<?php echo home_url('/'); ?>">
			<img src="<?php echo get_template_directory_uri() . '/assets/images/logo.jpg'; ?>" alt="" />
		</a>
	</div>
	<!-- End of logo -->
	<div class="left-navbar-wrapper">
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
