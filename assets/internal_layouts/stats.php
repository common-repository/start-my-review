<div class='uk-text-meta'>
	Business General Overview
</div>
<canvas id="bizVisits"></canvas>
<canvas id="bizComments"></canvas>
<canvas id="bizRatings"></canvas>
<?php if (!$haveBusinesses): ?>
	<div>
		You have not created a business yet, please add your business by clicking on the "Businesses" option
	</div>
<?php endif?>

<?php
$bds = array(); //BDS = business data set
if ($haveBusinesses) {
	foreach ($businesses as $biz) {
		$bds[] = array('views' => $biz->site_views, 'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)), 'name' => json_decode($biz->site_data)->business_name);
	}
	?>
	<script type="text/javascript">
		var ctx = document.getElementById("bizVisits");
		var defaultOptions = {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: [
				<?php foreach ($bds as $d) {
					echo "'$d[name]',";
				}
				?>
				],
				datasets: [{
					label: 'Total businesses visits',
					data: [
					<?php foreach ($bds as $d) {
						echo $d['views'] . ",";
					}
					?>
					],
					backgroundColor: [
					<?php foreach ($bds as $d) {
						echo "'$d[color]'" . ",";
					}
					?>
					]
				}]
			},
			options: defaultOptions
		});
	</script>
	<?php

}

?>

<!-- Reviews count -->

<?php
if ($haveBusinesses) {
	foreach ($businesses as $b) {
		$a[] = $b->id;
	}
	$reviewsRating = $wpdb->get_results("SELECT count(rating), rating from {$wpdb->prefix}startmyreview_comments where business_id in (" . implode(',', $a) . ") group by rating");
	?>
	<script type="text/javascript">

		var data = {
			datasets: [{
				data: [<?php foreach ($reviewsRating as $x) {echo $x->{'count(rating)'} . ",";}?>],
				backgroundColor: [<?php foreach ($reviewsRating as $x) {echo "'" . sprintf('#%06X', mt_rand(0, 0xFFFFFF)) . "',";}?>]
			}],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
    <?php foreach ($reviewsRating as $x) {echo "'Reviews with a " . $x->rating . " stars rating',";}?>
    ]
};
new Chart(document.querySelector('#bizComments'),{
	type: 'pie',
	data: data,
});
</script>
<?php
}
?>


<script type="text/javascript">
	if (window.DELCANVAS == true) {
		document.querySelectorAll('#bizVisits, #bizComments, #bizRatings').forEach(function(e) {
			e.remove();
		})
	}
</script>