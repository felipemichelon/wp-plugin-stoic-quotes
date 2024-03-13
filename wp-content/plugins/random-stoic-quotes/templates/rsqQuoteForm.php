<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2>Quote <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=random_stoic_quotes'); ?>">Voltar para a lista</a>
    </h2>

    <?php if (!empty($notice)) : ?>
        <div id="notice" class="error">
            <p><?php echo $notice ?></p>
        </div>
    <?php endif; ?>
    <?php if (!empty($message)) : ?>
        <div id="message" class="updated">
            <p><?php echo $message ?></p>
        </div>
    <?php endif; ?>

    <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>" />
        <?php /* Observação: Nós estamos armazenando id para veriricar se será adicionado ou atualizado */ ?>
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>" />

        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    <?php /* Aqui chamamos nosso custom meta box */ ?>
                    <?php do_meta_boxes('random_stoic_quotes_meta_box', 'normal', $item); ?>
                    <input type="submit" value="Salvar" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>
</div>