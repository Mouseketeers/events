<div id="EventsWidget">
	<% if Events %>
	<% control Events %>
	<div class="activities clickable" onclick="location.href='$Link'">
		<h2><a href="$Link">$Title</a></h2>
		<p><small class="date">$Venue, $FromDate.FormatI18N(%e. %B %Y) kl. $Time</small></p>
		<% if PageImage %>$PageImage<% end_if %>
		<p>$Abstract</p>
		<p><a href="$Link">Læs mere</a></p>
	</div>
	<% end_control %>
	<% else %>
	<p>$NoEventsMessage</p>
	<% end_if %>
</div>
