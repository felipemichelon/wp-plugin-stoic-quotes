<div class="wrap">
    <form action="options.php" method="POST">
        <?php 
        settings_fields("randomstoicquotes_options");
        do_settings_sections("randomstoicquotes_settings_sections");
        submit_button();
        ?>
    </form>
</div>