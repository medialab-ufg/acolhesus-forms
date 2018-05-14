<table class="table table-hover">
        <thead>
        <tr>
            <th> Campo de Atuação </th>
			<th> Nome </th>
			
			<?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
	            <th> Data Criação </th>
	            <th> Autor </th>
			<?php endif; ?>

            <th> Status </th>
            <?php if (current_user_can('acolhesus_cgpnh')) { ?>
                <th> Ação </th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if ( have_posts() ) {
            while(have_posts()): the_post();
            $author_id = get_the_author_meta( 'ID' );
            $_form_id = get_the_ID();
            $_is_form_locked = get_post_meta($_form_id, "locked", true);
            ?>
                <tr>
                    <td> 
						<strong> 
							<?php echo get_post_meta($_form_id, "acolhesus_campo")[0];  ?>
						</strong> 
					</td>
					<td>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title( '<h3 class="panel-title">', '</h3>' ); ?>
                        </a>
                    </td>
                    
					<?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
						<td> <?php the_time( 'd/m/Y - G:i:s'); ?> </td>
	                    <td> <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author(); ?></a> </td>
					<?php endif; ?>

                    <td>
                        <?php if ($_is_form_locked): ?>
                            <span class="closed">Fechado </span>
                        <?php else: ?>
                            <span class="open">Aberto</span>
                        <?php endif; ?>
                    </td>

                    <?php if (current_user_can('acolhesus_cgpnh')) { ?>
                        <td>
                        <?php if ($_is_form_locked): ?>
                            <button class="btn btn-default btn-primary" style="float: right; margin-right: 10px;">
                                <a class="unlock_form_entries" data-id="<?php echo $_form_id; ?>"
                                   data-txt="<?php echo get_the_title(); ?>"
                                   style="color: white" href="javascript:void(0)">
                                    ABRIR EDIÇÃO
                                </a>
                            </button>
                        <?php else: ?>
                            <button class="btn btn-default btn-danger" style="float: right; margin-right: 10px;">
                                <a class="lock_form_entries" data-id="<?php echo $_form_id; ?>"
                                   data-txt="<?php echo get_the_title(); ?>"
                                   style="color: white">
                                    FECHAR EDIÇÃO
                                </a>
                            </button>
                        <?php endif; ?>

                        </td>
                    <?php } ?>
                </tr>
            <?php
            endwhile;
        }
        ?>
        </tbody>
    </table>

    <?php
    if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)) { ?>
        <div class="col-md-12">
            <p>
                <input type="hidden" id="new_post_type" name="new_post_type" value="<?php echo $current_acolhesus_formtype; ?>">
                <button class="btn btn-info" id="add_acolhesus_entry">Nova resposta de <?php echo post_type_archive_title(); ?> </button>
            </p>
        </div>
        <?php
    }
    ?>

