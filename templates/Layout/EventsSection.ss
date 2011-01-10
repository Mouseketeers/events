<h1>$Title</h1>
$Content
<% if ContentList %>
<div id="ContentList">
	<% control ContentList %>
	<div class="listItem clickable" onclick="location.href='$Link'">
		<h2>$Title</h2>
		<p class="date">$FromDate.Long - $ToDate.Long</p>
		<p>$Image.SetWidth(80) $Content.firstParagraph</p>
		<p><a href="$Link" class="readMore">Læs mere</a></p>
	</div>
	<% end_control %>
	<% include Pagination %>
</div>
<% end_if %>