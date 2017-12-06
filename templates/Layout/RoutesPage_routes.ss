<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<% with $ChallengeRoute %>
				<table>
					<tr>
						<td>Split</td>
						<td>Hits</td>
						<td>PB</td>
						<td>Best</td>
						<td>Curr</td>
					</tr>
				<% loop Splits %>
					<tr>
						<td>$Title</td>
						<td id="Hits" class="Hits">$Hits</td>
						<td>$PB</td>
						<td>$Best</td>
						<td>$Curr</td>
					</tr>
				<% end_loop %>
				</table>
				<table>
					<tr>
						<td>PB</td>
						<td>Sum of Best</td>
						<td>Resets</td>
						<td>Completed Runs</td>
						<td>Is Complete</td>
						<td>Character</td>
					</tr>
					<tr>
						<td>$PB</td>
						<td>$SumOfBest</td>
						<td>$Resets</td>
						<td>$CompletedRuns</td>
						<td>$IsComplete</td>
						<td>$Character.Name</td>
					</tr>
				</table>
			<% end_with %>
			<a id="addHit" href="{$Link}addHit?splitID={$ChallengeRoute.ID}">
				<button>
					Add Hit
				</button>
			</a>
			<a id="removeHit" class="removeHit" href="{$Link}removeHit?splitID={$ChallengeRoute.ID}">
				<button>
					Remove Hit
				</button>
			</a>
			<br /><br /><br />
			<a id="resetRun" class="resetRun" href="{$Link}resetRun?splitID={$ChallengeRoute.ID}">
				<button>
					Reset Run
				</button>
			</a>
			<a id="resetWholeRoute" class="resetWholeRoute" href="{$Link}resetWholeRoute?splitID={$ChallengeRoute.ID}">
				<button>
					Reset Whole Route
				</button>
			</a>
			<br /><br /><br />
			<a id="makeSplit" class="makeSplit" href="{$Link}makeSplit?splitID={$ChallengeRoute.ID}">
				<button>
					Do Split
				</button>
			</a>
			<a id="previousSplit" class="previousSplit" href="{$Link}previousSplit?splitID={$ChallengeRoute.ID}">
				<button>
					Previous Split
				</button>
			</a>
			<a id="nextSplit" class="nextSplit" href="{$Link}nextSplit?splitID={$ChallengeRoute.ID}">
				<button>
					Next Split
				</button>
			</a>
			<br /><br /><br />
			<a id="saveSplits" class="saveSplits" href="{$Link}saveSplits?splitID={$ChallengeRoute.ID}">
				<button>
					Save Splits &amp; Reset
				</button>
			</a>

		</div>
	</article>
		$Form
		$CommentsForm
</div>