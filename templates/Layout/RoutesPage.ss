<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content

			<ul>
				<% loop ChallengeRoutes %>
					<li><a href="{$Link}" target="_blank">$Title</a></li>
				<% end_loop %>
			</ul>

		</div>
	</article>
		$Form
		$CommentsForm
</div>