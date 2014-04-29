<!-- File: /app/View/Projects/add.ctp -->


<!-- 
http://book.cakephp.org/2.0/en/tutorials-and-examples/blog/part-two.html
<form id="PostAddForm" method="post" action="/posts/add">
 -->
<?php
echo $this->Form->create('Project');
echo $this->Form->input('name');
//echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->end('Save Project');
?>