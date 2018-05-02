
    <table class="table table-hover">
        <thead>
        <tr>
            <th> Campo de Atuação </th>
			<th> Nome </th>
			
			<?php if ($AcolheSUS->can_add_entry(get_post_type())): ?>
	            <th> Data Criação </th>
	            <th> Autor </th>
			<?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if ( have_posts() ) {
            while(have_posts()): the_post();
            $author_id = get_the_author_meta( 'ID' );  ?>
                <tr>
                    <td> 
						<strong> 
							<?php echo get_post_meta(get_the_ID(), "acolhesus_campo")[0];  ?> 
						</strong> 
					</td>
					<td>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title( '<h3 class="panel-title">', '</h3>' ); ?>
                        </a>
                    </td>
                    
					<?php if ($AcolheSUS->can_add_entry(get_post_type())): ?>
						<td> <?php the_time( 'd/m/Y - G:i:s'); ?> </td>
	                    <td> <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author(); ?></a> </td>
					<?php endif; ?>
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

