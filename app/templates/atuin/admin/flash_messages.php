<div class="container atuinFlashMessagesAdmin">
    <?php $messages = flash_message_get() ?>
    <?php foreach ($messages as $message) { ?>
		<div class="alert alert-<?= $message[1] ?> alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?= $message[0] ?>
		</div>
    <?php } ?>
</div>
