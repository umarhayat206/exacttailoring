{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<tr>
<td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<font color="{$section_head_txt}"><b>{$signup_terms_title}</b></font></td>
</tr>
<tr>
<td width="25%" bgcolor="{$lighter_cells}" rowspan="2" align="center"><img border="0" src="images/cp_terms.gif" width="32" height="32"></td>
<td width="75%" colspan="3" bgcolor="{$lighter_cells}">&nbsp;<textarea rows="5" name="terms" cols="50">{$terms_t}</textarea></td>
</tr>
{if isset($terms_required)}
<tr>
<td width="75%" colspan="3" bgcolor="{$lighter_cells}"><input type="checkbox" name="accepted" value="1"{$terms_checked}>&nbsp;{$signup_terms_agree}</font></td>
</tr>
{else}
<tr><td width="75%" colspan="3" bgcolor="{$lighter_cells}" height="1"></td></tr>
{/if}
<tr><td width="100%" colspan="4" height="5"></td></tr>


