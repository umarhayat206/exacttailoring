<?php


if($_GET['delId']!="" && $_SESSION['auth']!="false"){
	tsMembers::memberDelete($_GET['delId']);
}

if($_GET['mIdShop']>0){
	//Store a copy of the current administrator
	$_SESSION['backToAdminUser'] = $_SESSION['auth'];
	//Get member details to go shopping with
	$_SESSION['auth'] = tsMembers::memberGet($_GET['mIdShop']);
	//Redirect to site front end
	//header("location: index.php");
	echo "<script language='javascript' type='text/javascript'>window.location='index.php';</script>";
}
	//print_r($_SESSION['auth']);
	//echo("<br /><br />");
	//print_r($_SESSION['backToAdminUser']);
	//echo("<br /><br />");
	//print_r($_SESSION);
	
	
function memberList($keywords){
	$members = new tsMembers;
	$members = $members->memberList("m_lastname LIMIT 0,50",$keywords);
	foreach($members as $member){
		echo("
			<tr>
				<td>".($member->mLockedOut==1?"<img src='styles/images/lock.png' title='Member access blocked' alt='Padlock icon' />":"")."</td>
				<td>".(tsMembers::memberShowRoleIcon($member->mRole))."</td>
				<td class='action'><a href='admin-contacts?delId=".$member->mId."' title='Delete contact' onclick='javascript:return confirm(\"Are you sure you want to delete this member?\")' ><img src='styles/images/cross.png' alt='Delete contact' /></a></td>
				<td class='action'><a href='admin-contacts?mId=".$member->mId."' title='Edit contact' ><img src='styles/images/pencil.png' alt='Edit contact' /></a></td>
				<td class='action'><a href='admin-contacts?mIdShop=".$member->mId."' title='Go shopping as this user' ><img src='styles/images/shopping_cart.gif' alt='Go shopping as this user' /></a></td>
				<td>".$member->mFirstname."</td>
				<td>".$member->mLastname."</td>
				<td>".$member->mEmail."</td>
				<td>".tsShoppingCart::scGetOrderCount($member->mId)."</td>
				<td>&pound; ".tsShoppingCart::scGetSalesTotal($member->mId)."</td>
				<td>".smFunctions::displayDate($member->mLastActivity)."</td>
				<td>".smCountries::countryById($member->mCountry)."</td>
			</tr>");
	}
}

function memberListColumns(){
	echo("
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th colspan='3'>
					Actions
				</th>
				<th>
					First name
				</th>
				<th>
					Last name
				</th>
				<th>
					Email
				</th>
				<th>Orders</th>
				<th>Sales</th>
				<th>Last login</th>
				<th>
					Country
				</th>	
			</tr>
		");
}

?>