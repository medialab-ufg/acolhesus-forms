<?php include_once( get_theme_file_path('header-full.php') ); ?>



<?php if (!current_user_can('view_acolhesus')): ?>
    <center> Permissão negada </center>
<?php else: ?>
    <h1>Formulários Acolhe SUS</h1>
    <?php
    global $AcolheSUS;
    $camposDoUsuario = get_user_meta(get_current_user_id(), 'acolhesus_campos');

    foreach ($AcolheSUS->forms as $formName => $formAtts):

        $formularios = new WP_Query([
            'post_type' => $formName,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => 'acolhesus_campo',
                    'value' => $camposDoUsuario,
                    'compare' => 'IN'
                ]
            ]
        ]);

        if ($formularios->have_posts()):
            ?>

            <h3><?php echo $formAtts['labels']['name']; ?></h3>
            <ul>
                <?php while ($formularios->have_posts()): $formularios->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php

        endif;    

    endforeach;
    ?>

<?php endif; ?>


<?php include_once( get_theme_file_path('footer-full.php') ); ?>