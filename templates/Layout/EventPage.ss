<h1>$Title</h1>
<p class="date">$FromDate.Long <% if ToDate %> - $ToDate.Long<% end_if %></p>
$EventImage.SetWidth(160)
$Content
$Form
<% if OtherEvents %>
<div id="OtherEvents">
	<h2>Other Events</h2>
	<% control OtherEvents %>
	<div class="listItem clickable" onclick="location.href='$Link'">
		<p class="date">$FromDate.FormatI18N(%e. %B %Y) - $ToDate.FormatI18N(%e. %B %Y)</p>
		<h4><a href="$Link">$Title</a></h4>
	</div>
	<% end_control %>
</div>
<% end_if %>