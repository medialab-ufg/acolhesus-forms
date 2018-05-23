<?php include_once( get_theme_file_path('header-full.php') ); ?>

<div class="acolhesus-form-container">
    <h3>
        <?php the_title(); ?>

        <?php if (get_post_meta(get_the_ID(), 'locked', true)): ?>
            <span style="color: red; font-style: italic; font-size: 10px"> preenchimento encerrado </span>
        <?php endif; ?>

        <?php if (current_user_can('acolhesus_cgpnh')): ?>
            <a class="btn btn-default list-entries" href="<?php echo get_post_type_archive_link(get_post_type()); ?>"> VER TODAS RESPOSTAS </a>
        <?php endif; ?>
    </h3>

    <hr>
    <?php the_content(); ?>

    <?php if ( comments_open() || get_comments_number()) : ?>
        <div class="panel hidden-print">
            <h3>Diligências</h3>
            <div class="panel-footer panel-comentarios">
                <?php comments_template(); ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>