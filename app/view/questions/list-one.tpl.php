<?php

	$question =	$question->getProperties();
	extract($question);
?>

<div class='grid'>
	<?=$html = "<div class='one-question'>";?>
	<h1><?= $subject ?></h1>
	<?php
			$user = $this->UserController->getUserAction($userId);
			$tags = $this->TagsController->getTagsByQuestion($id);
			$html .= "<span class='date'>" . $created . "</span>";
			$html .= "<article>";
			
			$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
			
			$html .= "</article><hr><span class='tags'>";

				foreach ($tags as $id => $name) {
					$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
				}


			$html .= "</span><span class='user'>";
			$html .= "Ställd av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span>";
			
		
		$html .= "</div>";

				foreach ($answers as $answer) {
					$answer =	$answer->getProperties();
					extract($answer);
					$user = $this->UserController->getUserAction($userId);
					$html .= "<span class='date'>" . $created . "</span>";
					$html .= "<article>";
					
					$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
					
					$html .= "</article><hr><span class='tags'>";

					$html .= "</span><span class='user'>";
					$html .= "Ställd av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span>"; 
				}
		echo $html;

		echo $form;
	
	
	?> 	
	<pre><?= var_dump($answers) ?></pre>
</div>