<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 29.12.17
 * Time: 18:02
 */
if ( $post->tags ) : ?>
	<p class="tags">
		<?php foreach ( $post->tag_links as $tag => $tag_link ) : ?>
			<a href="<?= $tag_link ?>" class="btn btn-warning btn-xs">
				<small><?= $tag ?></small>
			</a>
		<?php endforeach; ?>
	</p>
<?php endif; ?>