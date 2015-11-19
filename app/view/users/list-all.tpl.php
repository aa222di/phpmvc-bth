<div class='grid'>
	<h1><?=$title?></h1>
	<?php 
	 if (isset($users[0])){
	$keys = array_keys($users[0]->getProperties());
	$thead = '<thead>';
	foreach ($keys as $key => $value) {
		if ($value != 'password') {
		$thead .= '<th>' . $value . '</th>';
		}
	}
	$thead .= '<th>Delete</th><th>Edit</th></thead>';
	$tbody = '<tbody>';
	foreach ($users as $user) {
		$values = $user->getProperties();
		$tbody .= '<tr>';
		foreach ($values as $key => $value) {
			if ($key == 'id') {
				$url = $this->url->create('user/id/' . $value);
				$tbody .= '<td><a href="' . $url . '">' . $value . '</a></td>';
			}
			elseif ($key != 'password') {
			$tbody .= '<td>' . $value . '</td>';
			}
		}
		$edit = $this->url->create('user/update/' . $values['id']);
		$delete = $this->url->create('user/softDelete/' . $values['id']);
		$tbody .= '<td><a href="' . $edit . '">Edit</a></td><td><a href="' . $delete . '">Delete</a></td></tr>';
	}
	$tbody .= '</tbody>';
	$table = '<table>' . $thead . $tbody . '</table>';

	echo $table; 
	}
	?> 
	<nav>
		<a href="<?=$this->url->create('user/setup/');?>">Setup</a> 
		<a href="<?=$this->url->create('user/add/');?>">Add user</a> 
		<a href="<?=$this->url->create('user/active/');?>">View only active users</a> 
		<a href="<?=$this->url->create('user/trashcan/');?>">View trashcan</a> 
	</nav>
</div>
 
