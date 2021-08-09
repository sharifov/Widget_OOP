<form action="<?=PROJECT_URL . $plugin?>" method="post">

	<div class="form">
		<label>Please Select Plugin for send Message:</label> 
		
		<br/><br/>

		<select name="start">
			<option value="0">Not Selected</option>
			
			<?foreach($plugins as $plg):?>

				<option <?if($plg == $plugin):?>selected="selected"<?endif?> value="<?=$plg?>"><?=$plg?></option>

			<?endforeach?>
		</select>
	</div>
	
	<?=$fields_html?>

</form>	

<script type="text/javascript">
	$('select[name="start"]').change(function() {
		let _val = $(this).val().trim();
		$('#content').load( $('base').attr('href') + _val);
	});

</script>