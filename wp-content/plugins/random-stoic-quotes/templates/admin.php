<div class="wrap">
    <form method="post" action="options.php">
        <?php
        settings_fields('rsq_options');
        do_settings_sections('rsq_admin');
        submit_button();
        ?>
    </form>
</div>