500
<p>
	<?php
	/** @var \Exception $exception */
	echo $exception->getMessage();
	echo nl2br($exception->getTraceAsString());
	?>
</p>