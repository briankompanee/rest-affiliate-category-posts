<?php

/*
 * This file is part of WordPress Widget Boilerplate
 * (c) Tom McFarlin <tom@tommcfarlin.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */
?>
<ul class="bb-rest-affiliate-category-posts-list">
  <?php foreach( $posts as $post ) : ?>
    <li>
      <a href="<?php echo esc_url( $post->link ) ?>">
          <?php echo esc_html( $post->title->rendered ); ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>