
<div class="left-container-wrapper t-d-view">
	<div class="top-info-box">
		<div class="top-lf-info">
			<div class="img-box pos-rel" style="background-image: url('images/test-img-1.jpg');">
				<img src="images/blank.png">
				<span class="icon-photo"></span>
				<div class="shadow">Новое фото</div>
			</div>
			<p class="balance">Баланс</p>
			<p><span class="rubel">18 245</span>рублей</p>
		</div>
		<div class="top-rt-info">
			<h2 class="name">Константин Константиновский</h2>
			<p class="age">39 лет</p>
			<p class="address">г. Санкт-Петербург</p>
			<div class="fill-balance md-trigger" data-modal="modal-18">
				пополнить баланс
			</div>
		</div>
	</div>
	<div class="profile-menu">
		<ul>
			<li>
				<a href="">Мои ставки</a>
				<span class="count fr">5+</span>
			</li>
			<li>
				<a href="">asdasd</a>
				<span class="count fr">5+</span>
			</li>
			<li><a href="">Мой счет</a></li>
			<li><a href="">Мои подписчикиt</a></li>
			<li><a href="">Мои подписки</a></li>
			<li <?php if (strpos($_SERVER['PHP_SELF'], 'profile-message.php')) echo 'class="selected"';?>>
				<a href="">Мои сообщения</a>
				<span class="count fr">5+</span>
			</li>
			<li><a href="">Мои новости</a></li>
			<li><a href="">Мои группы</a></li>
			<li <?php if (strpos($_SERVER['PHP_SELF'], 'my-competition.php')) echo 'class="selected"';?>><a href="my-competition.php">Мои конкурсы</a></li>
			<li><a href="">Моя статистика</a></li>
			<li><a href="">Мои настройки</a></li>
		</ul>
	</div>
	<div class="polygon-wrapper">
		<div class="circle polygon fl brand-red-bg">
			<p class="font32 pl white pos-abs">3200</p>
			<p class="mg-top">место</p>
		</div>

		<div class="circle polygon fl brand-blue-bg">
			<p class="font32 pl white pos-abs">412</p>
			<p class="mg-top">прогнозов</p>
		</div>

		<div class="circle polygon fl yellow-bg">
			<p class="font32 pl white pos-abs">+ 120</p>
			<p class="mg-top">% прибыли</p>
		</div>
	</div>
</div>


				