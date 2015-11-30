<div class='grid'>

	<?php
			extract($content);
			$user = $this->UserController->getUserAction($userId);


			$html = "<nav class='go-back'><a href=" . $this->url->create('questions/list') . ">Gå tillbaka till alla frågor</a></nav>";
			$html .= "<div class='content'>";
			$html .= "<h1>Kommentera</h1>";
			$html .= "<article>";
			$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
			$html .= "</span><span class='user'>";
			$html .= "Ställd av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span>";

		$html .= "</section><hr><section class='comments'><h3>Kommentarer</h3>";

		foreach ($comments as $comment) {
			$user = $this->UserController->getUserAction($comment->userId);
			$html .= "<div class='comment'><span class='text'>" . $comment->text . "</span><span class='date'>" . $comment->created . "</span><span class='user'><a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->acronym . "</a></span></span></div>";
		}

		$html .= "</section><hr>";
	
		echo $html;

		echo $form;
	
	
	?> 	
</div>