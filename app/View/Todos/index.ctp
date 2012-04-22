<?php

$this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false);

$this->Html->script('todos.js', false);

if (count($todos) === 0) echo "<h3>No todos yet, add some below.</h3>";
else
foreach ($todos as $todo)
{
    echo "<div class='well' id='todo-{$todo['Todo']['id']}'><p style='float:left;'>{$todo['Todo']['description']}</p>
    <div style='float:right;'>
    <a style='cursor:pointer;' class='edit'>Edit</a> | <a style='cursor:pointer;' class='delete'>Delete</a> | Done: <input class='todo-done' type='checkbox' ";
    if ($todo['Todo']['done']) echo "checked='checked'";
    echo " /></div></div>";
}

?>
<div id="new-todo-div">
    <input id="new-todo" placeholder="New todo" type="text" style="width:300px;" />
</div>
<?php echo $this->Paginator->numbers(array('first' => 'First page')); ?>