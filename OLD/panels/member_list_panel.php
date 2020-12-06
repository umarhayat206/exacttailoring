<div id="memberList" class="adminPanel">
	<div class="addNew"><a href="<?php echo($_SERVER['PHP_SELF']);?>?mId=new" title="Add a new contact">Add new contact</a></div>
	<form id="memberListFilter" class="search" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<fieldset>
			<?php smControls::smButton("Search","mSearch","class='searchButton'");?>
			<?php smControls::smTextBox("Filter","mFilter",$_POST['mFilter']);?>
		</fieldset>
	</form>
	<h2>Current Contacts</h2>
	<table>
		<thead>
				<?php memberListColumns();?>
		</thead>
		<tfoot>
				<?php memberListColumns();?>
		</tfoot>
		<tbody>
			<?php memberList($_POST['mFilter']);?>
		</tbody>
	</table>
</div>

