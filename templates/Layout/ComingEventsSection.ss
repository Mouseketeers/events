<% include LeftMenu %>

<h1>Coming Events</h1>
$Content


<% control UpcomingEvents(6) %>
	<% include EventItem %>
<% end_control %>
