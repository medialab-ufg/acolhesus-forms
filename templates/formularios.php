<?php include_once( get_theme_file_path('header-full.php') ); ?>

<?php if (!current_user_can('view_acolhesus')): ?>
    <center> Permissão negada </center>
<?php else: ?>
    <div class="acolhesus-form-container col-md-12 lista-geral">
        <h1 style="text-align: center; color: black">Política Nacional de Humanização - Formulários Acolhe SUS </h1>
        <hr>

        <center>
            <img width="10%" src="http://redehumanizasus.net/wp-content/uploads/2017/09/logo-humanizasus-em-alta-300x231.jpg" />
        </center>

        <hr>
    
    <?php
    global $AcolheSUS;
    $camposDoUsuario = $AcolheSUS->get_user_campos();

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

        if ($formularios->have_posts()): ?>

            <h3>
                <a href="<?php echo get_post_type_archive_link($formName); ?>"> <?php echo $formAtts['labels']['name']; ?> </a>
            </h3>


            <?php /* TODO: abstrair template da tabela para o loop */ ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th> Campo de Atuação </th>
                    <th> Resposta </th>
                    <th> Data Criação </th>
                    <th> Autor </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($formularios->have_posts()): $formularios->the_post(); ?>
                    <tr> 
                        <td> <strong> <?php echo get_post_meta(get_the_ID(), "acolhesus_campo")[0];  ?> </strong> </td>
                        <td> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a> </td>
                        <td> <?php the_time( 'd/m/Y - G:i:s ' ); ?> </td>
                        <td> <?php echo get_the_author(); ?> </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

            </table>

            <?php

        endif;    

    endforeach;
    ?>

    </div>
<?php endif; ?>


<?php include_once( get_theme_file_path('footer-full.php') ); ?>