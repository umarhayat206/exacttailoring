<div id="productTypeList" class="adminPanel">
	<form id="productTypeListFilter" class="search" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<fieldset>
			<?php smControls::smButton("Search","ptSearch","class='searchButton'");?>
			<?php smControls::smTextBox("Filter","ptFilter",$_POST['ptFilter']);?>
		</fieldset>
	</form>
	<h2>Products</h2>
	<table>
		<thead>
			<?php productTypeColumns();?>
		</thead>
		<tfoot>
			<?php productTypeColumns();?>
		</tfoot>
		<tbody>
			<?php productTypeList($_POST['ptFilter']);?>
		</tbody>
	</table>
	<?php // productTypeList($_POST['ptFilter']);?>
</div>