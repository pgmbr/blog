<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 22.1.18
 * Time: 12:51
 */
?>

<div class="form-group" id="tags-checkfield">
	<?php foreach ( get_post_tags( $post->id ) as $tag ) : ?>
		<label class="checkbox">
			<input type="checkbox" name="tags[]" value="<?= $tag->id ?>"
				<?= isset( $tag->checked ) && $tag->checked ? 'checked' : '' ?>>
			<?= plain( $tag->tag ) ?>
		</label>
	<?php endforeach; ?>
</div>
