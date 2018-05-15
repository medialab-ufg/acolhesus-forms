<?php include_once( get_theme_file_path('header-full.php') ); ?>

<div class="acolhesus-form-container">
    <h3>
        <?php the_title(); ?>

        <?php if (get_post_meta(get_the_ID(), 'locked', true)): ?>
            <span style="color: red; font-style: italic; font-size: 10px"> preenchimento encerrado </span>
        <?php endif; ?>

        <?php if (current_user_can('acolhesus_cgpnh')): ?>
            <button class="btn btn-default" style="float: right; background: #003c46">
                <a style="color: white" href="<?php echo get_post_type_archive_link(get_post_type()); ?>"> VER TODAS RESPOSTAS </a>
            </button>
        <?php endif; ?>
    </h3>

    <hr>
    <?php the_content(); ?>
</div>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>