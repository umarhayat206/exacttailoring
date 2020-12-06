<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	counter = <?php echo((tsFabrics::ftGetCollectionCount($fType->ftId))+1);?>;
	$('#addNew').click(function(){
		counter ++;
		$('.mGroup').append("<fieldset><legend>Fabric " + counter + "<\/legend><input id='fId" + counter + "' name='fId" + counter + "' value='' type='hidden' \/><label for='fName" + counter + "'>Name<\/label><input id='fName" + counter + "' name='fName" + counter + "' value='' type='text'  \/><br \/><label for='fCode" + counter + "'>Code<\/label><input id='fCode" + counter + "' name='fCode" + counter + "' value='' type='text'  \/><br \/><label for='fPrice" + counter + "'>Price (&pound;)<\/label><input id='fPrice" + counter + "' name='fPrice" + counter + "' value='' type='text' \/><br \/><label for='fImage" + counter + "'>Swatch image<\/label><input id='fImage" + counter + "' name='fImage" + counter + "' value='' type='file' \/><br \/><\/fieldset>");	
	});
})	
//]]>
</script>
<form id="fabricForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
	<h3>Add/Edit fabrics</h3>
	<fieldset>
		<legend>Fabric collection</legend>
		<?php smControls::smHiddenText("ftId",$fType->ftId);?>
		<?php smControls::smTextBox("Group name","ftName",$fType->ftName);?><br />
		<?php smControls::smTextArea("Group Description","ftDescription",$fType->ftDescription);?><br />
		<?php smImages::showThumb($fType->ftImagepath,$fabrics->ftName,160);?><br />
		<?php smControls::smFileUpload("Group image","ftImage");?><br />
	</fieldset>
	<div class="mGroup">
		<?php addFabrics($fType->ftId);?>
	</div> 
	<fieldset>
		<legend>Save or add new fabric</legend>
		<div id="addNew">Add more...</div>
		<?php smControls::smButton("Save all","Save");?>
	</fieldset>
</form>