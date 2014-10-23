<?php
use oat\tao\helpers\Template;
?>
<div id="meta-content" class="content-block">
    <input type="hidden" id="uri" value="<?= get_data('uri'); ?>" />
	<table class="matrix">
		<thead>
			<tr>
				<th class="first"><?=__('Date')?></th>
				<th><?=__('User')?></th>
				<th class="last"><?=__('Comment')?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach (get_data('comments') as $comment) :?>
			<tr>
				<td class="first"><?=$comment['date']?></td>
				<td><?=$comment['author']?></td>
				<td class="last">
					<span><?=$comment['text']?></span>
				</td>
			</tr>
			<?php endforeach;?>
			<tr id="meta-addition">
				<td class="first" colspan="2"/>
				<td class="last">
					<span id="comment-field"><?=get_data('comment')?></span>
					<a href="#" id="comment-editor" title="<?=__('Edit Comment')?>">
						<img src="<?= Template::img('edit.png', 'tao')?>" alt="<?=__('Edit Comment')?>" />
					</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>