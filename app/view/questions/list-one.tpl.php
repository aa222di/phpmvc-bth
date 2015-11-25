<?php

	$question =	$question->getProperties();
	extract($question);
?>

<div class='grid'>

	<?php

			$user = $this->UserController->getUserAction($userId);
			$tags = $this->TagsController->getTagsByQuestion($id);
			$questionId = $id;
			$html = "<nav class='go-back'><a href=" . $this->url->create('questions/list') . ">Gå tillbaka till alla frågor</a></nav>";
			$html .= "<div class='one-question'>";
			$html .= "<section class='main-question'>";
			$html .= "<h1>" . $subject . "</h1>";
			$html .= "<span class='date'>" . $created . "</span>";
			$html .= "<article>";
			$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
			
			$html .= "</article><hr><span class='tags'>";

				foreach ($tags as $id => $name) {
					$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
				}


			$html .= "</span><span class='user'>";
			$html .= "Ställd av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span>";

			
		$html .= "<nav class='small-button-nav'><a href=" . $this->url->create('comments/form/question/' . 	$questionId ) . ">Lämna kommentar</a></nav>";
		
		$html .= "</section><section class='comments'><h5>Kommentarer</h5>";
		$comments = $this->CommentsController->getCommentsForQuestion($questionId);
		foreach ($comments as $comment) {
			$user = $this->UserController->getUserAction($userId);
			$html .= "<div class='comment'><span class='text'>" . $comment->text . "</span><span class='date'>" . $comment->created . "</span><span class='user'><a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span></span></div>";
		}
		$html .= "</section>";


		$html .= "<section class='answers'>";
		$html .= "<h2>" . count($answers) . " svar</h2>";

				foreach ($answers as $answer) {
					$answer =	$answer->getProperties();
					extract($answer);
					$user = $this->UserController->getUserAction($userId);
					$html .= "<div class='answer'>";
					$html .= "<span class='date'>" . $created . "</span>";
					$html .= "<article>";
					
					$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
					
					$html .= "</article><hr><span class='tags'>";

					$html .= "</span><span class='user'>";
					$html .= "Svar skrivet av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span>"; 
					$html .= "<nav class='comment-link'><a href=" . $this->url->create('comments/form/answer/' . $id) . ">Lämna kommentar</a></nav>";


					$comments = $this->CommentsController->getCommentsForAnswer($id);
					foreach ($comments as $comment) {
						$user = $this->UserController->getUserAction($userId);
						$html .= "<div class='comment'><span class='text'>" . $comment->text . "</span><span class='date'>" . $comment->created . "</span><span class='user'><a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span></span></div>";
					}

					$html .= "</div>";
				}
		$html .= "</section></div>";
		
		echo $html;

		echo $form;
	
	
	?> 	
</div>