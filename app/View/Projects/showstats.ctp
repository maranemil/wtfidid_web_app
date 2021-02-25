<div class="control-btn">
	<a href="<?= $this->webroot ?>projects/showstatsall">Total Report</a>
</div>

<ul class="projects-list">
	<?php
	foreach ($report as $entry) {
		echo '
			<li class="project">
				<span> <img src="' . $this->webroot . 'img/statistics-icon2.png"> ' . $entry . ' </span>
			</li>
			';
	}
	?>
</ul>


