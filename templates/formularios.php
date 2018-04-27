<?php include_once( get_theme_file_path('header-full.php') ); ?>

<?php if (!current_user_can('view_acolhesus')): ?>
    <center> Permissão negada </center>
<?php else: ?>
    <div class="acolhesus-form-container col-md-12">
        <h1 style="text-align: center; color: black">Política Nacional de Humanização - Formulários Acolhe SUS </h1>
        <hr>

        <center>
            <img width="10%" src="http://redehumanizasus.net/wp-content/uploads/2017/09/logo-humanizasus-em-alta-300x231.jpg" />
        </center>

        <hr>
    
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

    </div>
<?php endif; ?>


<?php include_once( get_theme_file_path('footer-full.php') ); ?>