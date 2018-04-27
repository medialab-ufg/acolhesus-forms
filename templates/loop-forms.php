<h1 class="acolhesus-archive-title">
    <?php echo post_type_archive_title('Formulários: '); ?>
</h1>
<?php
if ( have_posts() ) {
    while(have_posts()): the_post();
    $author_id = get_the_author_meta( 'ID' );
    ?>
        <div class="panel panel-default col-md-3">
            <div class="panel-body">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title( '<h3 class="panel-title">', '</h3>' ); ?>
                </a>
            </div>
            <div class="panel-footer">
                <span class="post-date text-uppercase"> <span style="font-size: 10px"> Publicado em </span> <?php the_time( 'd/m/Y' ); ?></span>
                <br>
                <span class="text-uppercase" style="font-size: 10px"> por </span>  <span class="nome-author"> <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author(); ?></a> </span>
            </div>
        </div>
        <!-- .panel .panel-default .col-md-3-->
        <div style="margin-left: 1%; float: left; position: relative; width: 10px; height: 10px;"></div>
    <?php
    endwhile;
}

?>

<div class="col-md-12">
    <p>
        <input type="hidden" id="new_post_type" name="new_post_type" value="<?php echo get_post_type(); ?>">
        <button class="btn btn-info" id="add_acolhesus_entry">Nova resposta de <?php echo post_type_archive_title(); ?> </button>
    </p>
</div>