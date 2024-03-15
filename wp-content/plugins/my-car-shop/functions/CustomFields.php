<?php

function CustomFields()
{
    add_meta_box(
        'Cars_cf',
        'Cars Details',
        'myCustomFieldsFunction',   // Custom fields function
        'cars',                     // Custom post type title
        'normal',
        'low'
    );
}
function myCustomFieldsFunction()
{
	$car_price = get_car_price();
    ?>
    <h3>Car Price</h3>
    <div class="input">
        <input class="input-text" type="text" name="price" value="<?php echo $car_price; ?>">
    </div>
    <?php
}

function get_car_price()
{
	global $wpdb;
	$car_id = get_the_id();
	$table_name = $wpdb->prefix .'my_car_shop';
	$car_price = $wpdb->get_var("SELECT `price` FROM $table_name WHERE car_id=$car_id");

	return $car_price;
}

function save_custom_fields($post_id)
{
	$price = $_POST['price'];
	$car_id = get_the_id();
	$car_title = get_the_title();
	
	global $wpdb;
	$table_name = $wpdb->prefix .'my_car_shop';

	$totalRegistries = $wpdb->get_var("SELECT count(id) FROM $table_name WHERE car_id=$car_id");
	if($totalRegistries > 0){
		$wpdb->update(
			$wpdb->prefix .'my_car_shop',
			array(
				'price'=> $price,
				'title'=> $car_title,
			),
			array(
				'car_id' => $car_id,
			)
		);
	} else {
		$wpdb->insert(
			$wpdb->prefix .'my_car_shop',
			array(
				'car_id'=> $car_id,
				'price'=> $price,
				'title'=> $car_title,
			)
		);
	}

}
add_action('save_post','save_custom_fields');