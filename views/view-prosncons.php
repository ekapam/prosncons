<div class="header">
    <h2>Shortcode:</h2>
    <span>[prosncons_shortcode id="<?= get_the_ID()?>"]</span>
</div>
<div id="grid">
	<div class="pros">
		<span class="title"><i class="fa fa-check-circle"></i> Pros</span>
		<table id="pros" class="form-table">
			<tbody><?= $prosDOMBody; ?></tbody>
			<tfoot>
				<tr>
					<td>
						<input type="text" />
						<button data-target="pros" onclick="event.preventDefault(); Product.addItem($(this).data('target'), $(this).prev());" class="button button-secondary add"><i class="fa fa-plus-circle"></i></button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="cons">
		<span class="title"><i class="fa fa-times-circle"></i> Cons</span>
		<table id="cons" class="form-table">
			<tbody><?= $consDOMBody; ?></tbody>
			<tfoot>
				<tr>
					<td>
						<input type="text" />
						<button data-target="cons" onclick="event.preventDefault(); Product.addItem($(this).data('target'), $(this).prev());" class="button button-secondary add"><i class="fa fa-plus-circle"></i></button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>