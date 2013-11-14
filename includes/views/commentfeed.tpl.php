<tr>
	<td>
		<!-- user image -->
		<?php
			$imgSize = 50;
			$imgDefault = "http://getrti.co.in/assets/images/default-avatar.png";
			$grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($_ITEM->User->Email))) . "?d=" . urlencode($imgDefault) . "&s=" . $imgSize;
			echo "<img src='".$grav_url."'/>";
		?>
	</td>
	<td>
		<!-- user comment -->
		<p class="text-muted"><?php _p($_ITEM->Comment); ?></p><small> - <?php _p($_ITEM->User->Name); ?></small>
	</td>
</tr>