<?php
/**
 * Single event template
 * @version 1.0
 */

get_header(); 
global $post;
?>

<div class="main-container">

	<div class="middle-container-wrapper-2col">

		<div class="top-notification-wrapper pos-rel">
			<div class="top-left-angel"></div>
			<div class="bottom-right-angel"></div>
			<div class="text-holder">
				<p class="white">Ставки сделанные в этом рынке пойдут в зачет конкурса <span>«Звезды НБА»</span></p>
			</div>
			<div class="timer-box">
				<div class="div-center">
					<p class="p1" id="days">60<br><span>дней</span></p>
					<p class="p1" id="hours">09<br><span>часов</span></p>
					<p class="p1" id="min">42<br><span>минут</span></p>
					<p class="p1" id="sec">34<br><span>секунд</span></p>
				</div>
			</div>
			<div class="close-abs no-bg white">
				<span class="icon-close"></span>
			</div>
		</div>

		<div class="mg-top"></div>

		<h1 class="fl wd-auto"><?php the_title(); ?></h1>

		<div class="star-wrapper fl pos-rel">
			<div class="close-abs hover">
				<span class="icon-starempty brand-blue"></span>
				<div class="hover-box">
					В избранное
					<span class="icon-arrowdropdown"></span>
				</div>
			</div>
		</div>

		<p class="url fl mg-top">
			<span>Главная</span> / <span>Ставки на футбол </span> / <span>Чемпионат мира</span>/ Франция - Германия, 18 марта, 18:0-0
		</p>

		<div class="select-wrapper fr">
			<form action="#" method="get">
				<p>
					<select class="turnintodropdown">
						<option>Коэффициенты William Hill</option>
						<option>England</option>
		  				<option>Northern Ireland</option>
		  				<option>Scotland</option>
					</select>
				</p>
			</form>
		</div>
		
		<div class="clear"></div>


		<div class="actual-events mg-top">
			<!-- First -->
			<h3><?php esc_html_e('Обе забьют', 'socialbet'); ?></h3>
			<div>
				<div class="row use-shadow">
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>

				<div class="mg-top"></div>
			</div>

			<h3><?php esc_html_e('Первый гол', 'socialbet'); ?></h3>
			<div>
				<div class="row use-shadow">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray"><?php print __('ничья', 'socialbet'); ?></span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>
				<div class="mg-top"></div>
			</div>

			<h3>Больше/меньше</h3>
			<div>
				<div class="row use-shadow">
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Больше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Меньше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						10,00
					</div>
				</div>
				<div class="row use-shadow">
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Больше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Меньше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						10,00
					</div>
				</div>
				<div class="row use-shadow">
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Больше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Меньше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						10,00
					</div>
				</div>
				<div class="row use-shadow">
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Больше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Меньше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						10,00
					</div>
				</div>
				<div class="row use-shadow">
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Больше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Меньше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						10,00
					</div>
				</div>
				<div class="row use-shadow">
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Больше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-5 tx-al-lft white-bg fl">
						<span class="dark-gray">Меньше 0,5</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						10,00
					</div>
				</div>
				<div class="mg-top"></div>
			</div>


			<h3><?php esc_html_e('Точный счет', 'socialbet'); ?></h3>
			<div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft transparent font0 fl">
						<span class="dark-gray">&nbsp;</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft transparent font0 fl">
						<span class="dark-gray">&nbsp;</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft transparent font0 fl">
						<span class="dark-gray">&nbsp;</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Нет</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						4,43
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl">
						<span class="dark-gray">Да</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft transparent font0 fl">
						<span class="dark-gray">&nbsp;</span>
					</div>
					<div class="col-ng-1 tx-al-lft transparent font0 fl">
						<span class="dark-gray">&nbsp;</span>
					</div>
					<div class="col-ng-3 tx-al-lft transparent font0 fl">
						<span class="dark-gray">&nbsp;</span>
					</div>
					<div class="col-ng-1 tx-al-lft transparent font0 fl">
						<span class="dark-gray">&nbsp;</span>
					</div>
				</div>
				<div class="mg-top"></div>
			</div>


			<h3>1-й тайм результат/ 2-й тайм результат</h3>
			<div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ Франция выиграет второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ ничья второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">4,43</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ Манчестер Юнайтед выиграет второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">4,43</span>
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ Франция выиграет второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ ничья второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">4,43</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ Манчестер Юнайтед выиграет второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">4,43</span>
					</div>
				</div>
				<div class="row">
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ Франция выиграет второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">1,65</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ ничья второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">4,43</span>
					</div>
					<div class="col-ng-3 tx-al-lft white-bg fl special">
						<span class="dark-gray">Франция выиграет первый тайм/ Манчестер Юнайтед выиграет второй тайм</span>
					</div>
					<div class="col-ng-1 tx-al-cntr yellow-bg fl special">
						<span class="dark-gray">4,43</span>
					</div>
				</div>
				<div class="mg-top"></div>
			</div>
			<!-- end of fifth -->
			<!-- sixth -->
			<h3>Еще один рынок</h3>
			<div>
				<div class="mg-top"></div>
			</div>
			<!-- end of sixts -->
			<!-- seventh -->
			<h3>Еще один свернутый рынок</h3>
			<div>
				<div class="mg-top"></div>
			</div>
			<!-- end of seventh -->

		</div>

	</div>

	<?php // should show cart later ?>
	<div class="right-container-wrapper-2col bates-right white-bg">
		
	</div>


</div>

<?php get_footer(); ?>