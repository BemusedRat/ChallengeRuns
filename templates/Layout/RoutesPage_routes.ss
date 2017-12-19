<div class="content-container">
	<article>
			<% if $CurrentMember %>
				<section class="buttonsWrapper">
					<a id="addHit" class="addHit" href="{$Link}addHit?splitID={$ChallengeRoute.ID}">
						<button>
							+ Add Hit
						</button>
					</a>
					<a id="removeHit" class="removeHit" href="{$Link}removeHit?splitID={$ChallengeRoute.ID}">
						<button>
							- Remove Hit
						</button>
					</a>
					<a id="makeSplit" class="makeSplit" href="{$Link}makeSplit?splitID={$ChallengeRoute.ID}">
						<button>
							SPLIT &raquo;&raquo;
						</button>
					</a>
					<a id="saveSplits" class="saveSplits" href="{$Link}saveSplits?splitID={$ChallengeRoute.ID}">
						<button>
							Save Splits &amp; Reset
						</button>
					</a>
					<a id="resetRun" class="resetRun" href="{$Link}resetRun?splitID={$ChallengeRoute.ID}">
						<button>
							Reset Run
						</button>
					</a>
					<% if $SimpleView %><% else %>
						<a id="previousSplit" class="previousSplit" href="{$Link}previousSplit?splitID={$ChallengeRoute.ID}">
							<button>
								&lt; Previous Split
							</button>
						</a>
						<a id="nextSplit" class="nextSplit" href="{$Link}nextSplit?splitID={$ChallengeRoute.ID}">
							<button>
								Next Split &gt;
							</button>
						</a>
						<a id="resetWholeRoute" class="resetWholeRoute" href="{$Link}resetWholeRoute?splitID={$ChallengeRoute.ID}">
							<button>
								Reset Whole Route
							</button>
						</a>
					<% end_if %>
				</section>
			<% end_if %>
			<% if $SimpleView %>
				<div class="simpleview challenge-container">
					<div class="challenge-header">
						<h3>$ChallengeRoute.Title</h3>
					</div>
					<div class="challenge-split">
						<table>
							<tr class="table-headings">
								<td>Current Split</td>
								<td>Hits</td>
							</tr>
							<tr>
								<td>$SplitTitle</td>
								<td>$CurrentSplit.Hits</td>
							</tr>
						</table>
					</div>
					<div class="challenge-route">
						<table>
							<tr class="table-headings">
								<td>Character</td>
								<td>Hits so far...</td>
								<td>PB</td>
								<td>Sum of Best</td>
								<% if $CurrentMember %>
									<td>Is Complete</td>
									<td>Levelled Dex</td>
								<% end_if %>
							</tr>
							<tr>
								<td>$ChallengeRoute.Character.Name</td>
								<td>$HitsTotal</td>
								<td>$ChallengeRoute.PB</td>
								<td>$SumOfBest</td>
								<% if $CurrentMember %>
									<td>$ChallengeRoute.IsComplete</td>
									<td>$ChallengeRoute.LevelledDex</td>
								<% end_if %>
							</tr>
						</table>
					</div>
				</div>
			<% else %>
			<h1>$Title</h1>
			<div class="content">
			$Content
				<% with $ChallengeRoute %>
					<table>
						<tr class="table-headings">
							<td class="split-title">Split</td>
							<td>Hits</td>
							<td>PB</td>
							<td>Best</td>
							<% if $CurrentMember %>
								<td>Curr</td>
								<td>Completed</td>
							<% end_if %>
						</tr>
					<% loop Splits %>
						<tr>
							<td class="split-title">$Title</td>
							<td id="Hits" class="Hits">$Hits</td>
							<td>$PB</td>
							<td>$Best</td>
							<% if $CurrentMember %>
								<td>$Curr</td>
								<td>$Completed</td>
							<% end_if %>
						</tr>
					<% end_loop %>
					</table>
					<table>
						<tr class="table-headings">
							<td>Hits so far...</td>
							<td>PB</td>
							<td>Sum of Best</td>
							<td>Resets</td>
							<td>Completed Runs</td>
							<% if $CurrentMember %>
								<td>Is Complete</td>
							<% end_if %>
							<td>Character</td>
						</tr>
						<tr>
							<td>$HitsTotal</td>
							<td>$PB</td>
							<td>$SumOfBest</td>
							<td>$Resets</td>
							<td>$CompletedRuns</td>
							<% if $CurrentMember %>
								<td>$IsComplete</td>
							<% end_if %>
							<td>$Character.Name</td>
						</tr>
					</table>
				<% end_with %>
			<% end_if %>

		</div>
	</article>
		$Form
		$CommentsForm
</div>