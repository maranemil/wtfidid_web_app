<div class="control-btn">
	<a href="<?= $this->base ?>/projects/add">Add New Project</a>
</div>
<?php
/*echo $this->Html->link(
'Add Project',
array('controller' => 'projects', 'action' => 'add')
);*/
?>
<ul class="projects-list">
	<?php
	foreach ($projects as $project) {
		echo '
                <li class="project">
					<a href="' . $this->base . '/projects/edit/' . $project['Project']['id'] . '" class="project-bttn">
						<img src="' . $this->webroot . 'img/edit-icon.png" alt="">
					</a>
					<a href="' . $this->base . '/projects/delete/' . $project['Project']['id'] . '" class="project-bttn">
						<img src="' . $this->webroot . 'img/delete-icon.png" alt="">
					</a>
                    <span> ' . $project['Project']['name'] . ' </span>
                </li>
                ';
	}
	?>
</ul>
<div class="control-btn">
	<a href="<?= $this->base ?>/projects/showstats">Show Report</a>
</div>
