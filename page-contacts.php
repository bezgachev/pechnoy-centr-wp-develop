<?
/*
Template Name: Контакты
Template Post Type: page
*/
?>
<?get_header();?>
<?woocommerce_breadcrumb();?>
<section class="contacts container">
	<div class="contacts__descr">
		<h1>Контакты</h1>
		<!-- <a href="https://go.2gis.com/5ohik" target="_blank" class="contacts__descr_address"> -->
				<!-- Республика&nbsp;Марий&nbsp;Эл, <br>
				пгт.&nbsp;Медведево, ул.&nbsp;Чехова,&nbsp;д.&nbsp;16Б -->
				<?contacts_address('contacts');?>
			<!-- </a> -->
		<div class="contacts__descr_tel">
			<?contacts_phone();?>
		</div>
		<?$email = get_option('admin_email');?>
		<div class="contacts__descr_duty"><?contacts_work_time();?></div><a class="contacts__descr_mail" href="mailto:<?echo $email;?>"><?echo $email;?></a>
		<div class="contacts__descr_social">
			<div class="social">
				<?contacts_messeng_social();?>
			</div>
		</div>
	</div>
	<div class="contacts__requisites">
		<h2>Реквизиты компании <span>ООО “<?bloginfo('name');?>”</span></h2>
		<div class="contacts__requisites_item"><span>Юр. адрес:</span>
			<p><?echo get_field('contacts-yur_address');?></p>
		</div>
		<div class="contacts__requisites_item"><span>ИНН:</span>
			<p><?echo get_field('contacts-inn');?></p>
		</div>
		<div class="contacts__requisites_item"><span>КПП:</span>
			<p><?echo get_field('contacts-kpp');?></p>
		</div>
		<div class="contacts__requisites_item"><span>ОГРН:</span>
			<p><?echo get_field('contacts-ogrn');?></p>
		</div>
		<div class="contacts__requisites_item"><span>Банк:</span>
			<p><?echo get_field('contacts-bank');?></p>
		</div>
		<div class="contacts__requisites_item"><span>БИК:</span>
			<p><?echo get_field('contacts-bik');?></p>
		</div>
		<div class="contacts__requisites_item"><span>Расч. счет:</span>
			<p><?echo get_field('contacts-rasch_schyot');?></p>
		</div>
		<div class="contacts__requisites_item"><span>Кор. счет:</span>
			<p><?echo get_field('contacts-korresp_schyot');?></p>
		</div><a download="Реквизиты <?bloginfo('name');?>" href="<?echo get_field('contacts-down_requisites');?>" class="download-details">Скачать реквизиты</a></div>
</section>
<div class="contacts__map-address d-hide">
	<span data-type-geo="Офис" data-addr="<?contacts_address('map');?>" data-geo="<?echo get_field('contacts-geo');?>" data-2gis="<?echo get_field('contacts-2gis');?>"></span>
</div>
<div class="contacts__map">
	<div class="map" id="map" style="width:100%;height:487px;"></div>
</div>
<?get_footer();?>