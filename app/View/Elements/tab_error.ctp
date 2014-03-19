<div id="alert" class="alert alert-danger">
	<?php foreach ($message as $error): ?>
		<p><?php echo $error[0]; ?></p>
	<?php endforeach; ?>
</div>
<script>$("#alert").delay(5000).fadeOut(1000);</script>