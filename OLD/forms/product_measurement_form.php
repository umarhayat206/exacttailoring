<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	counter = <?php echo((tsProductMeasurements::pmGetCollectionCount($currentGroup->pmgId))+1);?>;
	$('#addNew').click(function(){
		counter ++;
		$('.mGroup').append("<fieldset><legend>Measurement " + counter + "<\/legend><input id='pmId" + counter + "' name='pmId" + counter + "' value='' type='hidden' \/><label for='pmName" + counter + "'>Measurement name<\/label><input id='pmName" + counter + "' name='pmName" + counter + "' value='' type='text'  \/><br \/><label for='pmOrderNumber" + counter + "'>Order number<\/label><input id='pmOrderNumber" + counter + "' name='pmOrderNumber" + counter + "' value='' type='text'  \/><br \/><label for='pmCheckbox" + counter + "'>Checkbox option<\/label><input id='pmCheckbox" + counter + "' name='pmCheckbox" + counter + "' value='1' type='checkbox'   \/><br \/><label for='pmImage" + counter + "'>Descriptive image<\/label><input id='pmImage" + counter + "' name='pmImage" + counter + "' value='' type='file'  \/><br \/><br \/><\/fieldset>");
		
	});
})	
//]]>
</script>
<form id="productMeasurementForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
	<fieldset>
		<legend>Add/Edit product measurement group</legend>
		<?php smControls::smHiddenText("pmgId",$currentGroup->pmgId);?>
		<?php smControls::smTextBox("Group name","pmgGroupName",$currentGroup->pmgName);?><br />
		<?php smImages::showThumb($currentGroup->pmgImage,$currentGroup->pmgName,370);?>
		<?php smControls::smFileUpload("Group image","pmgGroupImage");?>
	</fieldset>
	<div class="mGroup">
		<?php addCurrentMeasurements($currentGroup->pmgId);?>
	</div>
	<fieldset>
		<legend>Save or add new measurements</legend>
		<div id="addNew">Add more...</div>
		<?php smControls::smButton("Save all","Save");?>
	</fieldset>
</form>
<?php
/** Original mGroup append
$('.mGroup').append("<fieldset><legend>Measurement " + counter + "<\/legend><input id='pmId" + counter + "' name='pmId" + counter + "' value='' type='hidden' \/><label for='pmName" + counter + "'>Measurement name<\/label><input id='pmName" + counter + "' name='pmName" + counter + "' value='' type='text'  \/><br \/><label for='pmOrderNumber" + counter + "'>Order number<\/label><input id='pmOrderNumber" + counter + "' name='pmOrderNumber" + counter + "' value='' type='text'  \/><br \/><label for='pmCheckbox" + counter + "'>Checkbox option<\/label><input id='pmCheckbox" + counter + "' name='pmCheckbox" + counter + "' value='1' type='checkbox'   \/><br \/><label for='pmImage" + counter + "'>Descriptive image<\/label><input id='pmImage" + counter + "' name='pmImage" + counter + "' value='' type='file'  \/><br \/><h4>Optional drop down menu details<\/h4><label for='pmOptionGroup" + counter + "'>Option group name<\/label><input id='pmOptionGroup" + counter + "' name='pmOptionGroup" + counter + "' value='' type='text'  \/><br \/><label for='pmOptionGroupValue" + counter + "'>Option value<\/label><input id='pmOptionGroupValue" + counter + "' name='pmOptionGroupValue" + counter + "' value='' type='text'  \/><br \/><\/fieldset>");
**/ 
?>