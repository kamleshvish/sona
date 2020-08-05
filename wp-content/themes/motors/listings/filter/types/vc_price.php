<?php
if (empty($options)) {
    return;
}

$start_value = $options[0];
$end_value = (count($options) > 0) ? $options[count($options) - 1] : 0;

/*Current slug*/
$slug = 'price';

$info = stm_get_all_by_slug($slug);

$sliderStep = (!empty($info['slider']) && !empty($info['slider_step'])) ? $info['slider_step'] : 100;

$label_affix = $start_value . ' — ' . $end_value;

$min_value = $start_value;
$max_value = $end_value;

if(isset($_COOKIE["stm_current_currency"])) {
    $cookie = explode("-", $_COOKIE["stm_current_currency"]);
    $start_value = ($start_value * $cookie[1]);
    $end_value = ($end_value * $cookie[1]);
    $min_value = $start_value;
    $max_value = $end_value;
}

if(!empty($_GET['min_' . $slug])) {
    $min_value = intval($_GET['min_' . $slug]);
}

if(!empty($_GET['max_' . $slug])) {
    $max_value = intval($_GET['max_' . $slug]);
}

$vars = array(
    'slug' => $slug,
    'js_slug' => str_replace('-', 'stmdash', $slug),
    'label' => stripslashes($label_affix),
    'start_value' => $start_value,
    'end_value' => $end_value,
    'min_value' => $min_value,
    'max_value' => $max_value,
    'slider_step' => $sliderStep
);

?>
<div class="price_range_wrap">
    <div class="vc_price mts_semeht_price">
        <div class="stm-price-range-unit">
            <div class="stm-price-range"></div>
        </div>
        <!--<input type="text" name="min_price" id="stm_filter_min_price"/>
        <input type="text" name="max_price" id="stm_filter_max_price"/>-->
    </div>
</div>

<!--Init slider-->
<?php stm_listings_load_template('filter/types/vc_slider-js', $vars); ?>
