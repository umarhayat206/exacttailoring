<ul id="fabricChooser">
	<form id="frmFabricTypeSelector" method="get" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<?php smControls::smDropDownList("Change Fabric Collection","ftId",tsFabrics::ftArray(),$_GET['ftId'],"",false,true);?><br />
		<?php smControls::smButton("Select","select");?><br />
	</form>
	<?php
	if($ftId!=""){
	?>
		<div id="fabricTypeDetails">
			<?php
			if(!empty($curFabType->ftImagepath)){
			?>
			<img src="<?= $curFabType->ftImagepath; ?>" title="<?= $curFabType->ftName; ?>" alt="Fabric type image" />
			<?php
			}
			?>
			<?php
				echo($curFabType->ftDescription);
			?><br />
		</div>
	<?php
	}
	?>
<?php fabricList($ftId);?>
</ul>