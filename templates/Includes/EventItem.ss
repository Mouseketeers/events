<div class="EventItem">
	<h3>$Title</h3>
	<p class="date">
	<% if ToDate && FromDate %>
	$FromDate.Long - $ToDate.Long
	<% else %>
		<% if ToDate || FromDate %>
			<% if ToDate %>Until $ToDate.Long<% end_if %>
			<% if FromDate %>$ToDate.Long and continuing<% end_if %>
		<% else %>Ongoing Event
		<% end_if %>
	<% end_if %>
	</p>
	<p>$EventImage.SetWidth(80)$Content.firstParagraph</p>
	<p><a href="$Link">Read more</a></p>
</div>