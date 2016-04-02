<?php include("includephp/header.php"); ?>
			

<?php include("includephp/left-2nd-menu.php") ?>

<div class="middle-container-wrapper">
	<ul class="fl full-width zero-border settings-nav">
		<li><a href="">Общее</a></li>
		<li><a href="">Приватность</a></li>
		<li><a class="selected" href="">Черный список</a></li>
	</ul>
	<div class="clear"></div>
	<div class="settings-wrapper no-bg">
		<div class="search-box2 fr">
			<form methpd="post" action="/">
				<input type="text" placeholder="Начните вводить название">
				<button type="submit" class="search-button"><span class="icon-search"></span></button>
			</form>
		</div>
		<div class="clear"></div>
		<p class="brand-blue b pd-top">В вашем черном списке находятся 4 человека	</p>

		<div class="my-message-wrapper mg-top">
			<div class="white-bg">
				<img class="circle fl" src="images/test-img-1.jpg">
				<div class="name-box fl pos-rel">
					<div class="center">
						<p class="font14 b">Александра Константинова</p>
					</div>
				</div>
				<div class="message pos-rel fl">
					<p class="center dark-gray">
						Убрать из черного списка
					</p>
				</div>
			</div>
			<div class="white-bg">
				<img class="circle fl" src="images/test-img-1.jpg">
				<div class="name-box fl pos-rel">
					<div class="center">
						<p class="font14 b">Александра Константинова</p>
					</div>
				</div>
				<div class="message pos-rel fl">
					<p class="center dark-gray">
						Убрать из черного списка
					</p>
				</div>
			</div>
			
			
			<div class="white-bg pos-rel">
				<img class="circle fl" src="images/test-img-1.jpg">
				<div class="name-box fl pos-rel">
					<div class="center">
						<p class="font14 b">Анна Петрова</p>
						<p class="placeholder-color">Вчера в 13:56</p>
					</div>
				</div>
				<div class="message pos-rel fl">
					<p class="center">
						Восстановить
					</p>
				</div>
				<div class="gray-overlay pos-abs"></div>
			</div>
			<div class="white-bg">
				<img class="circle fl" src="images/test-img-1.jpg">
				<div class="name-box fl pos-rel">
					<div class="center">
						<p class="font14 b">Александра Константинова</p>
					</div>
				</div>
				<div class="message pos-rel fl">
					<p class="center dark-gray">
						Убрать из черного списка
					</p>
				</div>
			</div>
			<div class="white-bg">
				<img class="circle fl" src="images/test-img-1.jpg">
				<div class="name-box fl pos-rel">
					<div class="center">
						<p class="font14 b">Александра Константинова</p>
					</div>
				</div>
				<div class="message pos-rel fl">
					<p class="center dark-gray">
						Убрать из черного списка
					</p>
				</div>
			</div>
			
		</div>


		<div class="yellow-bg pos-abs notification t-d-view">
			<div class="close-abs no-bg dark-gray"><span class="icon-close"></span></div>
			<p>Вам осталось сделать <span class="pl font32">23</span> прогноза</p>
			<p>У Вас осталось на это <span class="pl font32">23</span> дней</p>
		</div>
	</div>
</div>
<?php include("includephp/right-container.php") ?>			

<?php include("includephp/modals.php") ?>
<?php include("includephp/footer.php") ?>