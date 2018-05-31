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

    <div id="form-accordion">

        <?php if ( comments_open() || get_comments_number()) : ?>
            <h3> Diligências </h3>
            <div class="panel hidden-print">
                <div class="panel-footer panel-comentarios"> <?php comments_template(); ?> </div>
            </div>
        <?php endif; ?>

        <h3> Histórico </h3>
        <div class="panel hidden-print">
            <div class="panel-footer panel-comentarios">
                <?php
                $logs = get_comments([
                    'include_unapproved' => true,
                    'type' => 'acolhesus_log',
                    'post_id' => get_the_ID()
                ]);
                ?>

                <?php foreach ($logs as $log): ?>
                    <div class="acolhesus-log">
                        <?php echo '<strong>' . date('d/m/Y H:i', strtotime($log->comment_date)) . '</strong>'; ?>:
                        <?php echo $log->comment_content; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


</div>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>