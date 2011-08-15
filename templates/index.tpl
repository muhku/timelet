{include file="header.tpl"}

<h2>Working hour reporting</h2>

<div class="inner">
<p><a href="?page=worklog">Report work done</a></p>
</div>

<h2>Personal working hours</h2>

<div class="inner">
	<table cellspacing="0" cellpadding="6" class="b">
	{foreach from=$personal_hours item=row name=tablerow}
  		<tr>
    	{foreach from=$row item=col name=tablecol}
			{if $smarty.foreach.tablerow.index == 0 or $smarty.foreach.tablecol.index == 0}
				<th>{$col}</th>
	        {else}
		    	<td>{$col}</td>
			{/if}
	    {/foreach}
		</tr>
	{/foreach}
	</table>
</div>

<h2>Project working hours</h2>

<div class="inner">
	<table cellspacing="0" cellpadding="6" class="b">
	{foreach from=$project_hours item=row name=tablerow}
        <tr>
		{foreach from=$row item=col name=tablecol}
            {if $smarty.foreach.tablerow.index == 0 or $smarty.foreach.tablecol.index == 0}
                <th>{$col}</th>
            {else}
                <td>{$col}</td>
            {/if}
		{/foreach}
        </tr>
	{/foreach}
	</table>

	<ol>
    {foreach from=$types item=type}
		<li>{$type->get_name()}</li>
    {/foreach}
	</ol>
</div>

{include file="footer.tpl"}
