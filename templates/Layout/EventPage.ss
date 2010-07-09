<p class="date">$FromDate.Long <% if ToDate %> to $ToDate.Long<% end_if %></p>
<h1>$Title</h1>
$EventImage.SetWidth(160)
$Content
$Form
<h2>Other Events</h2>
<% control OtherEvents %>
	<% include EventItem %>
<% end_control %>