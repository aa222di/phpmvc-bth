<div class='grid'>
	<h1><?=$title?></h1>
	<?php
		 if (isset($questions[0])){
		$html = "<div class='all-questions'>";
		foreach ($questions as $question) {
			extract($question);

			$user = $this->UserController->getUserAction($userId);
			$tags = $this->TagsController->getTagsByQuestion($id);

			$html .= "<div class='question'><h3>" . $subject . "</h3><h6> by " . $user->acronym . "</h6>";
			$html .= "<img src=" . get_gravatar($user->email,80) . ">";
			$html .= "<article>" . $this->textFilter->doFilter($text, 'shortcode, markdown') . "</article><hr><span class='tags'>";
				
				foreach ($tags as $id => $name) {
					$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
				}

			$html .= "</span><span class='date'>" . $created . "</span>";
			$html .= "</div>";
		}
		$html .= "</div>";
		echo $html;
	}
	
	?> 	
</div>