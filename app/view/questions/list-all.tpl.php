<div class='grid'>
	<h1><?=$title?></h1>
	<?php 

		if($this->UserController->isUserLoggedIn()) {
				?>
					<nav>
						<a href="<?=$this->url->create('questions/create/');?>">Lägg till ny fråga</a> 
					</nav>
				<?php
			}
		else {
				?>
					<nav>
						<a href="<?=$this->url->create('login');?>">Logga in för att kunna skriva frågor</a> 
					</nav>
				<?php
		}

	 if (isset($questions[0])){
	 	$questions = array_reverse($questions);
	
		$html = "<div class='all-questions'>";
		foreach ($questions as $question) {
			$user = $this->UserController->getUserAction($question->userId);
			$tags = $this->TagsController->getTagsByQuestion($question->id);


			$html .= "<div class='question'><h3><a href=" . $this->url->create('questions/id/' . $question->id) . ">" . $question->subject . "</a></h3> <h6>by " . $user->acronym . "</h6>";
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


	}

	?> 


</div>