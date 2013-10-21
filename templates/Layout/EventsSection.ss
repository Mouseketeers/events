<h1>$Title</h1>
$Content
<% if ContentList %>
<div id="ContentList">
	<% control ContentList %>
	<div class="listItem clickable" onclick="location.href='$Link'">
		<h2>$Title</h2>
		<p class="date">$FromDate.Long<% if ToDate %> - $ToDate.Long<% end_if %></p>
		<p>$Image.SetWidth(80) 
			<% if Abstract %>
				$Abstract
			<% else %>
			$Content.Summary</p>
			<% end_if %>
		<p><a href="$Link" class="readMore">Læs mere</a></p>
	</div>
	<% end_control %>
	<% include Pagination %>
</div>
<% end_if %>