<?php
namespace helpers;

class AlertAndRedirect
{
	public function __construct($message, $url = '#')
	{
		if (isset($message)) {
			echo "
				<script>
				alert('$message');
				window.location.href = '$url';
				</script>
			";
			exit;
		}
	}

	public static function redirect($url = '#')
	{
		echo "
			<script>
			window.location.href = '$url';
			</script>
		";
		exit;
	}
}
