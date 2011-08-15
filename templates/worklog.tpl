{include file="header.tpl"}

&laquo; <a href="?page=index">Back to main</a>

<p><strong>{$user->get_firstname()} {$user->get_lastname()}</strong></p>

<h2>Add a worklog entry</h2>

<form method="post" action="">
	<input type="hidden" name="action" value="save_worklog_entry" />
	<table>
	    <tr>
	        <th>Week</th>
	        <th>Year</th>
	        <th>Work type</th>
	        <th>Work description</th>
	        <th>Time worked</th>
	    </tr>
	    <tr valign="top">
	        <td><input name="week" type="text" size="2" value="{$cur_week}"/></td>
	        <td><input name="year" type="text" size="4" value="{$cur_year}"/></td>
	        <td>
				<select name="work_type_id">
				{foreach from=$types item=type}
					<option value="{$type->get_id()}">{$type->get_name()}</option>
				{/foreach}
				</select>
			</td>
	        <td><textarea name="work_description" rows="4" cols="20" style="width: 270px; height: 100px;"></textarea></td>
	        <td><input name="time_worked" type="text" size="4" value=""/> tuntia</td>
	        <td><input type="submit" value="Ok" /></td>
	    </tr>
	</table>
</form>

<h2>Worklog entries</h2>

<form action="" method="get">
	<table>
    	<tr>
        	<th>Week</th>
        	<th>Year</th>
   	 	</tr>
   	 	<tr>
        	<td><input type="text" name="week" value="{$cur_week}" /></td>
        	<td><input type="text" name="year" value="{$cur_year} "/></td>
    	</tr>
	</table>
	<input type="hidden" name="page" value="worklog" />
	<input type="submit" value="Get worklog entries" />
</form>

<table>
	<tr>
    	<th>Week</th>
        <th>Year</th>
	    <th>Work type</th>
        <th>Work description</th>
        <th>Time worked</th>
    </tr>

	{foreach from=$worklog_entries item=entry}
	{assign var=work_type value=$entry->get_work_type()}
	<tr>
		<td>{$entry->get_week()}</td>
		<td>{$entry->get_year()}</td>
		<td>{$work_type->get_name()}</td>
		<td>{$entry->get_work_description()}</td>
		<td>{$entry->get_time_worked()}</td>
	</tr>
	{/foreach}
</table>

{include file="footer.tpl"}
