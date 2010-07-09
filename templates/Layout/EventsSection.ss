<% include LeftMenu %>

<% if CurrentFilter == aktuelle %>
<h1>Aktuelle udstillinger</h1>
<% control Events %>
	<% include EventItem %>
<% end_control %>

<% else_if CurrentFilter == kommende %>
<h1>Kommende udstillinger</h1>
<% control UpcomingEvents %>
	<% include EventItem %>
<% end_control %>

<% else_if CurrentFilter == web %>
<h1>Webudstillinger</h1>
<% control WebEvents %>
	<% include EventItem %>
<% end_control %>

<% else %>
<h1>Udstillinger</h1>
<h2>Aktuelle udstillinger</h2>
<% control Events %>
	<% include EventItem %>
<% end_control %>
<h2>Kommende udstillinger</h2>
<% control UpcomingEvents %>
	<% include EventItem %>
<% end_control %>
<% end_if %>
