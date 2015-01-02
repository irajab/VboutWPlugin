<div class="wrap">
	<div id="{icon}" class="icon32">
		<br />
	</div>

	<h2><?php echo $title; ?></h2>

	<form method="post" action="options.php" id="<?php echo $id; ?>">
		<?php echo $hidden_fields; ?>
		
		<?php echo $flash_message; ?>

		<table class="form-table">
			<?php echo $input_fields; ?>

			<tr valign="top">
				<th scope="row">
					<input type="submit" class="button-primary" value="<?php echo $submit; ?>" />
				</th>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
</div>