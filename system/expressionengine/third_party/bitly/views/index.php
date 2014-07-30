<p>This module will cache the short urls so you only request bit.ly once for each unique URL - Documentation over at <a href='http://wedoaddons.com' target='_blank'>wedoaddons.com</a>.</p>
<p>&nbsp;</p>
<p><strong>Example usage:</strong></p>

<p>
<textarea readonly="readonly">
{exp:bitly bitly_login='YOUR_BITLY_LOGIN' bitly_api_key='YOUR_BITLY_API_KEY' url='{comment_url_title_auto_path}'}
</textarea>
</p>




<p>There are <strong><?=$num_cached?> URLs</strong> in your cache! <em>(view them in Tools -> Data -> SQL Manager -> Browse the 'exp_bitly' table)</em></p>

<?=form_open($_form_base.AMP.'method=empty_cache')?>

<div class="tableFooter">
	<div class="tableSubmit">

		<?=form_submit('empty_cache', lang('empty_cache'), 'class="submit"'); ?>

	</div>
</div> <!-- tableFooter -->

<?=form_close()?>