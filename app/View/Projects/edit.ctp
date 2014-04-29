<!-- File: /app/View/Posts/edit.ctp -->


<?php
// project
echo $this->Form->create('Project');
echo $this->Form->input('name');
//echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Post');
?>