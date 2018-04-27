<?php include_once( get_theme_file_path('header-full.php') ); ?>

<h1>Formulários Acolhe SUS</h1>

<?php if (!current_user_can('view_acolhesus')): ?>
    Permissão negada
<?php else: ?>

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

            <h2><?php echo $formAtts['labels']['name']; ?></h2>
            
            <?php while ($formularios->have_posts()): $formularios->the_post(); ?>

                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>

            <?php endwhile; ?>

            <?php



        endif;    





    endforeach;


    ?>


<?php endif; ?>


<?php include_once( get_theme_file_path('footer-full.php') ); ?>