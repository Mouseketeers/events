<div id="EventsWidget">
	<% if Events %>
	<% control Events %>
	<div class="EventsWidgetItem" onclick="location.href='$Link'">
		<p class="date">$FromDate.FormatI18N(%e. %B %Y) - $ToDate.FormatI18N(%e. %B %Y)</p>
		<h4><a href="$Link">$Title</a></h4>
	</div>
	<% end_control %>
	
	<% else %>
	<p>$NoEventsMessage</p>
	<% end_if %>
</div>
