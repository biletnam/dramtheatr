<?php include 'header.php' ?>
<?php include 'top-line-menu.php' ?>
<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
	<div class="title">
		<h1>Контакти</h1>
	</div><!-- end title -->
	<div class="contacts">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
						<div class="forma">
							<form id="form" class="form" method="post">
								<div style="width: 500px; outline: 1px solid #5D0808;">
									<p style="width: 320px; margin: 0 auto; color: #5D0808; font-weight: bold; font-size: 18px;">
										Адреса театру: Театральна площа, 4
									</p>
									<p style="width: 305px; margin: 0 auto; color: #5D0808; font-weight: bold; font-size: 18px;">
										Електронна пошта: dramteatr@i.ua
									</p>
									<p style="width: 265px; margin: 0 auto; color: #5D0808; font-weight: bold; font-size: 18px;">
										Телефони: 52-26-49 (дирекція)
									</p>
									<p style="width: 210px; margin: 0 auto; color: #5D0808; font-weight: bold; font-size: 18px;">
										55-17-14 (адміністрація)
									</p>
									<p style="width: 145px; margin: 0 auto; color: #5D0808; font-weight: bold; font-size: 18px;">
										52-50-85 (каса)
									</p>
								</div><br>
								<input type="text" name="name" placeholder="Ім'я" required="required">
								<input type="text" name="phones" placeholder="Номер телефона" required="required">
								<input type="email" name="mail" placeholder="Email" required="required">
								<textarea name="messages" cols="30" rows="5" placeholder="Повідомлення..."></textarea>
								<button type="submit">Відправити</button>
							</form>

							<?php
							$name = '';
							$phones = '';
							$messages = '';
							$mail = '';
							if (isset($_POST["name"])) $name = $_POST['name'];
							if (isset($_POST["phones"])) $phones = $_POST['phones'];
							if (isset($_POST["messages"])) $messages = $_POST['messages'];
							if (isset($_POST["mail"])) $mail = $_POST['mail'];
							$to      = 'kvdvadim@meta.ua';
							$subject = $name;
							$message = $messages;
							$phone   = $phones;
							$headers = $mail . "\r\n" .
												 'Reply-To: http://teatr.da-wsp.com.ua/' . "\r\n" .
												 'X-Mailer: PHP/' . phpversion();
							mail($to, $subject, $message,$phone, $headers);
							?>

							<div class="done">
								<img src="/img/done.png" height="128" width="128" alt="done">
								<p>Ваші дані відправлено!<br>Дякуємо за повідомлення.</p>
							</div><!-- end done -->
						</div><!-- end forma -->
					</div>
					<div class="col-md-6">
						<div class="map">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12
							!1m3!1d2654.575312025492!2d25.929004115654422!3d48.291785679
							236064!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4
							73408993e4a6903%3A0xad14b004cbe5e31f!2z0KfQtdGA0L3RltCy0LXRh
							tGM0LrQuNC5INCQ0LrQsNC00LXQvNGW0YfQvdC40Lkg0J7QsdC70LDRgdC90
							LjQuSDQo9C60YDQsNGX0L3RgdGM0LrQuNC5INCc0YPQt9C40YfQvdC-LdC00
							YDQsNC80LDRgtC40YfQvdC40Lkg0KLQtdCw0YLRgCDRltC8LiDQntC70YzQs
							9C4INCa0L7QsdC40LvRj9C90YHRjNC60L7Rlw!5e0!3m2!1sru!2sua!4v14
							59949110003" width="100%" height="450" frameborder="0"
							style="border:0; margin-top: 20px;" allowfullscreen></iframe>
						</div><!-- end map -->
					</div>
				</div><!-- end row -->
			</div><!-- end container -->
		</div><!-- end contacts -->
	</section><!-- end theatre -->
	<?php include 'footer.php' ?>
