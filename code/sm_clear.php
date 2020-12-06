<?php

/**
 * Title:-
 * Description:-
 * @copyright 2007
 */

switch ($_GET['pages']) {
	case "home":
		echo "<p class='clearForm'><a href='{$site_admin}' title='Clear Form'>(Clear Form)</a></p>";
		break;
	case "property":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=property' title='Clear Form'>(Clear Form)</a></p>";
		break;	
	case "testimonials":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=testimonials' title='Clear Form'>(Clear Form)</a></p>";
		break;	
	case "content":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=content' title='Clare Form'>(Clear Form)</a></p>";
		break;	
	case "manage":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=manage' title='Clear Form'>(Clear Form)</a></p>";
		break;	
	case "user":	
		echo "<p class='clearForm'><a href='{$site_admin}?pages=user' title='Clear Form'>(Clear Form)</a></p>";
		break;	
	case "member":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=member' title='Clear Form'>(Clear Form)</a></p> ";
		break;	
	case "newletter":
		echo "<p class='clareForm' style='font-size:11px;'><a href='{$site_admin}?pages=newletter' title='Clear Form'>(Clear Form)</a></p>";
		break;	
	case "location":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=location' title='Clear Form'>(Clear Form)</a></p>";
		break;
	case "casestudies":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=casestudies' title='Clear Form'>(Clear Form)</a></p>";
		break;
	case "feedback":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=feedback' title='Clear Form'>(Clear Form)</a></p>";
		break;
	case "building":
		echo "<p class='clearForm'><a href='{$site_admin}?pages=building' title='Clear Form'>(Clear Form)</a></p>";
		break;
	default:
		echo "<p class='clearForm'><a href='{$site_admin}' title='Clear Form'>(Clear Form)</a></p>";
		break;
}

?>
