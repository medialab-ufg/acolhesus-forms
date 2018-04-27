<div class="acolhesus-form-container col-md-12">
    <h1 class="acolhesus-archive-title"> <?php echo post_type_archive_title('Formulário: '); ?> </h1>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th> Nome </th>
            <th> Data Resposta </th>
            <th> Autor </th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ( have_posts() ) {
            while(have_posts()): the_post();
            $author_id = get_the_author_meta( 'ID' );  ?>
                <tr>
                    <td>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title( '<h3 class="panel-title">', '</h3>' ); ?>
                        </a>
                    </td>
                    <td> <?php the_time( 'd/m/Y' ); ?> </td>
                    <td> <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author(); ?></a> </td>
                </tr>
            <?php
            endwhile;
        }
        ?>
        </tbody>
    </table>

    <?php
    $_post_type = get_post_type();
    if ($AcolheSUS->can_add_entry($_post_type)) { ?>
        <div class="col-md-12">
            <p>
                <input type="hidden" id="new_post_type" name="new_post_type" value="<?php echo $_post_type; ?>">
                <button class="btn btn-info" id="add_acolhesus_entry">Nova resposta de <?php echo post_type_archive_title(); ?> </button>
            </p>
        </div>
        <?php
    }
    ?>

</div>