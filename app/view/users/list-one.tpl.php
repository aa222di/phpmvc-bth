<div class='grid one-user'>
<?php
			$html = "<div class='user'><img src=" . get_gravatar($user->email,120) . "></a>";

			
			if(empty($user->text)){
				$html .= "<article>" . $user->acronym  . " har inte skrivit något presentation ännu</article>";
			}
			else {
				$html .= "<article>" . $this->textFilter->doFilter($user->text, 'shortcode, markdown') . "</article>";
			}

		$html .= "</div><hr>";
		echo $html;
?>
</div>