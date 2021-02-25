<ul class="projects-list">
	<?php
	foreach ($report as $entry) {
		echo '
			<li class="project">
				<span> <img src="' . $this->webroot . 'img/statistics-icon.png"> ' . $entry . ' </span>
			</li>
			';
	}
	?>
</ul>


