<?php 
	$html = "<div class='all-questions'><h1>Senaste frågorna</h1>";
	foreach ($questions as $question) {
			$user = $this->UserController->getUserAction($question->userId);
			$tags = $this->TagsController->getTagsByQuestion($question->id);
			$answers = $this->AnswersController->getAnswers($question->id);


			$html .= "<div class='question'><h3><a href=" . $this->url->create('questions/id/' . $question->id) . ">" . $question->subject . "</a><span class='number-answers'> (" . count($answers) . " svar) </span></h3> <h6>by " . $user->acronym . "</h6>";
			$html .= "<img src=" . get_gravatar($user->email,80) . ">";
			$html .= "<article>" . $this->textFilter->doFilter($question->text, 'shortcode, markdown') . "</article><hr><span class='tags'> ";
				
				foreach ($tags as $id => $name) {
					$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
				}

			$html .= "</span>";
			$html .= "<span class='date'>" . $question->created . "</span>";
			$html .= "</div>";
	}
		$html .= "</div>";
		echo $html;




	?> 


