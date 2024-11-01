<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Web Intent Tweet Button Administration</h2>
	<?php print $msg?>
	<form action="" method="post" id="web_intent_tweet_conf_form">
		<h3><label for="twitter_username">Twitter Name</label></h3>
		<p>Enter your Twitter UserName:
		<input type="text" id="twitter_username" name="twitter_username" 
		value="<?php print get_option('twitter_username_block'); ?>"/> </p>
		<p class="submit"><input type="submit" name="submit" value="Update"/></p>
		<?php wp_nonce_field('web_intent_tweet_admin_options','web_intent_tweet_admin_nonce');?>
	</form>
</div>
