<?php
/**
 * Account my listing
 *
 * Template can be modified by copying it to yourtheme/ulisting/account/my-listing.php.
 **
 * @see     #
 * @package uListing/Templates
 * @version 1.3.6
 */

use uListing\Classes\StmListingTemplate;
use uListing\Classes\StmPaginator;
use uListing\Classes\StmUser;

wp_enqueue_script('ulisting-my-listing', ULISTING_URL . '/assets/js/frontend/ulisting-my-listing.js', array('vue'), ULISTING_VERSION, true);

$limit = 9;
$sections = [];
$view_type = "list";
$default_listing_type = null;

$query_var = explode('/', get_query_var(stm_page_endpoint()));
$data['query_var'] = $query_var;
$page = isset($query_var[0]) ? intval($query_var[0]) : 0;
$data['user_id'] = get_current_user_id();
$params = array('limit' => $limit, 'offset' => ($page > 1) ? (($page - 1) * $limit) : 0);
if (isset($_GET['order']))
    $params['order'] = esc_attr($_GET['order']);

if (isset($_GET['order_by']))
    $params['order_by'] = esc_attr($_GET['order_by']);
?>

<?php StmListingTemplate::load_template('account/navigation', ['user' => $user], true); ?>

    <div id="ulisting_my_listing" class="custom-panel p-t-30 p-b-30 ">
		<?php
		$i = 0;
		$listing_types = uListing_all_listing_types();
		?>
        <div class="stm-my-listings-sidebar">
            <div class="ulisting-user-listings">
                <h4><?php echo esc_html__( 'Transport Type', 'motors' ); ?></h4>
                <?php foreach ( $listing_types as $index => $listing_type ): ?>
                    <?php
                    $count = $user->getListings( true, [ 'listing_type_id' => $index ], '' );

                    if ( $i === 0 ) {
                        $default_listing_type = isset( $query_var[1] ) ? intval( $query_var[1] ) : $index;
                        $data['default_type'] = $default_listing_type;
                    }

                    $i++;
                    ?>

                    <?php if ( $count > 0 ): ?>
                        <div class="form-check-inline">
                            <label class="form-check-label"
                                   v-bind:class="{active:listing_type === <?php echo esc_attr( $index ) ?>}">
                                <div class="ico-wrap">
                                    <?php echo get_the_post_thumbnail( $index, 'full' ); ?>
                                </div>
                                <input type="radio" v-bind:checked="listing_type === <?php echo esc_attr( $index ) ?>"
                                       v-on:change="changeType(<?php echo esc_attr( $index ) ?>)" class="form-check-input"
                                       name="listing_types"><?php echo esc_attr( $listing_type ); ?>
                            </label>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php foreach ($listing_types as $type_index => $listing_type):?>
                <div class="ulisting-my-listing-sidebar" v-if="listing_type == <?php echo esc_attr($type_index);?>">
                    <h4><?php echo esc_html__( 'Sort by status', 'motors' ); ?></h4>
                    <ul class="my-listing-sidebar-wrap">
                        <li @click="change('all')" :class="{'is-active': isActive === 'all'}" class="my-listing-sidebar-item heading-font"><span><?php echo __('All', 'motors');?></span><span>(<?php echo esc_html($user->getListings(true, ['listing_type_id' => $type_index], ''))?>)</span></li>
                        <li @click="change('publish')" :class="{'is-active': isActive === 'publish'}" class="my-listing-sidebar-item heading-font"><span><?php echo __('Publish', 'motors');?></span><span>(<?php echo esc_html($user->getListings(true, ['listing_type_id' => $type_index], 'publish'))?>)</span></li>
                        <li @click="change('pending')" :class="{'is-active': isActive === 'pending'}" class="my-listing-sidebar-item heading-font"><span><?php echo __('Pending', 'motors');?></span><span>(<?php echo esc_html($user->getListings(true, ['listing_type_id' => $type_index], 'pending'))?>)</span></li>
                        <li @click="change('draft')" :class="{'is-active': isActive === 'draft'}" class="my-listing-sidebar-item heading-font"><span><?php echo __('Draft', 'motors');?></span><span>(<?php echo esc_html($user->getListings(true, ['listing_type_id' => $type_index], 'draft'))?>)</span></li>
                        <li @click="change('trash')" :class="{'is-active': isActive === 'trash'}" class="my-listing-sidebar-item heading-font"><span><?php echo __('Trash', 'motors');?></span><span>(<?php echo esc_html($user->getListings(true, ['listing_type_id' => $type_index], 'trash'))?>)</span></li>
                    </ul>
                </div>
            <?php endforeach;?>
        </div>
        <div class="user-listings-list">
			<?php
			foreach ( $listing_types as $id => $value ):
                ?>
                    <div class="stm-row" v-if="listing_type == <?php echo esc_attr($id) ?> && hasAccess">
							<template v-for="(listing, index) in listings[listing_type]">
                                <div class="stm-col-12" v-if="isActive === 'all' || isActive === listing.status">
                                    <div class="stm-row">
                                        <div class="stm-col-12">
                                            <div class="my-listing-item-wrap">
                                                <div v-html="listing.html"></div>
                                                <div class="actions-wrap">
                                                    <a class="btn btn-success w-full"
                                                       v-bind:href="'<?php echo stml_get_link( 'add_listing' ) ?>?edit=' + listing.id"><i class="fa fa-pencil"></i></a>
                                                    <button class="btn btn-primary w-full m-t-15 heading-font"
                                                            @click="()=>panel_feature_switch(listing.id)"><?php _e( 'Featured', 'motors' ) ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ulisting-account-my-listing-feature-plan" v-if="feature_panel == listing.id">
                                        <p v-if="loading"><?php echo __('Loading', 'motors');?></p>
                                        <div v-if="!loading">
                                            <div class="stm-row">
                                                <div v-for="plan in feature_plans" class="stm-col-12">
                                                    <div class="card-body">
                                                        <div class="plan-body-left">
                                                            <span v-if="plan.id == feature_plan_select"
                                                                  class="badge badge-success heading-font">Active</span>
                                                            <span v-if="plan.id == selected_plan"
                                                                  class="badge badge-success heading-font">Select</span>
                                                        </div>
                                                        <div class="plan-body-center-title">
                                                            <h5 class="card-title heading-font">{{plan.name}}</h5>
                                                        </div>
                                                        <div class="plan-body-center-limit">
                                                            <p v-if="plan.payment_type == 'subscription'" class="card-text heading-font">
                                                                {{plan.feature_limit}} / {{plan.use_feature_limit}}</p>
                                                            <p v-if="plan.payment_type == 'one_time'" class="card-text heading-font">
                                                                <span>Limit :</span>
                                                                {{plan.feature_limit}}
                                                            </p>
                                                        </div>
                                                        <div class="plan-body-center-timer">
                                                            <v-timer
                                                                    v-if="plan.listing_plan && plan.listing_plan.user_plan_id == feature_plan_select_is_one_tome"
                                                                    inline-template
                                                                    :starttime="moment.utc(plan.listing_plan.created_date).local().format('MM DD YYYY h:mm:ss')"
                                                                    :endtime="moment.utc(plan.listing_plan.expired_date).local().format('MM DD YYYY h:mm:ss')"
                                                                    trans='{
                                                             "day":"d",
                                                             "hours":"h",
                                                             "minutes":"m",
                                                             "seconds":"s",
                                                             "expired":"Event has been expired.",
                                                             "running":"Till the end of event.",
                                                             "upcoming":"Till start of event.",
                                                             "status": {
                                                                "expired":"Expired",
                                                                "running":"Running",
                                                                "upcoming":"Future"
                                                               }}'>
                                                                <div class="timer-wrap">
                                                                    <div class="timer-title heading-font">
                                                                        <?php echo esc_html__('Plan ends ih:', 'motors');?>
                                                                    </div>
                                                                    <div class="stm-row stm-no-gutters">
                                                                        <div class="stm-col-3 heading-font">
                                                                            <span class="number">{{ days }} {{ wordString.day }}</span>
                                                                            <span class="format"></span>
                                                                        </div>
                                                                        <div class="stm-col-3 heading-font">
                                                                            <span class="number">{{ hours }}</span>
                                                                            <span class="format">{{ wordString.hours }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </v-timer>
                                                        </div>
                                                        <div class="plan-body-right">
                                                            <button v-if="!feature_plan_select_is_one_tome"
                                                                    @click="select_feature_plan(plan)" class="btn btn-primary heading-font">
                                                                select
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul v-if="errors">
                                                <li v-for=" (val, key) in errors">{{val}}</li>
                                            </ul>
                                            <p v-if="message">{{message}}</p>
                                            <span v-if="loading_save">Loading...</span>
                                            <button v-if="!loading_save"
                                                    @click="()=>save(listing.id)"
                                                    class="btn btn-success heading-font"><?php _e( "Save", 'motors' ) ?></button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                    </div>
			<?php endforeach; ?>
            <!--<div class="stm-justify-content-center stm-add-btn-wrap" v-if="hasAccess || hasFail">
                <a class="btn btn-success heading-font" href="<?php /*echo stml_get_link( 'add_listing' ) */?>"> <?php /*_e( '+Add listing', 'motors' ) */?> </a>
            </div>-->
            <div class="stm-row stm-justify-content-center">
                <div class="stm-col-4" v-if="hasFail">
                    <p class="m-t-5"><?php echo __("No listings found", "motors")?></p>
                </div>
            </div>
            <div v-if="!preLoader" class="stm-row stm-justify-content-center" style="margin: 10px 0">
                <div class="stm-spinner"> <div></div> <div></div> <div></div> <div></div> <div></div> </div>
            </div>
        </div>
		<?php
		$data['pagination_settings'] = array(
			'maxPagesToShow' => 8,
			'class' => 'nav nav-pills',
			'item_class' => 'nav-item',
			'link_class' => 'nav-link',
		);
		?>
		<?php foreach ($listing_types as $id => $value): ?>
            <template v-if="listing_type == <?php echo esc_attr($id) ?> && hasAccess">
                <div class="stm-justify-content-center" v-html="paginator[listing_type]"></div>
            </template>
		<?php endforeach; ?>
    </div>
<?php
wp_add_inline_script( 'ulisting-my-listing', "var ulisting_my_listing_data = json_parse('" . ulisting_convert_content( json_encode( $data ) ) . "');", 'before' );