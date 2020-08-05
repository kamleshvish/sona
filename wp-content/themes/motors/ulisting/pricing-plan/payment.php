<?php
/**
 * Pricing plan payment
 *
 * Template can be modified by copying it to yourtheme/ulisting/pricing-plan/payment.php.
 **
 * @see     #
 * @package uListing/Templates
 * @version 1.0
 */

use uListing\Classes\StmUser;
use uListing\Classes\StmPaymentMethod;

$payment_data = array(
	'pricing_plan_id' => $pricing_plan->ID
);
$data                         = $pricing_plan->getData();
$payment_data['my_plans_url'] = StmUser::getUrl('my-plans');
$payment_script = [
	"selected" => "",
	"buy" => "",
	"send_request" => "",
	"success" => "",
];

$payment_data = apply_filters('ulisting_pricing_plan_payment_method_data', $payment_data);
?>
<div class="payment_box_wrap">
    <h3><?php esc_html_e( 'Checkout', 'motors' ); ?></h3>
    <div class="payment_box">
        <div class="payment_left_box">
            <h6><?php esc_html_e( 'Your plan', 'motors' ); ?></h6>

            <div class="pricing-plans_list">
                <ul>
                    <li>
                        <div class="pricing-plan-box">
							<?php $meta = $pricing_plan->getData(); ?>
                            <div class="pricing-plan-title"><?php echo esc_attr( $pricing_plan->post_title ); ?></div>
                            <div class="pricing-plan-price"><?php echo currencyFormat( $meta['price'] ); ?></div>
                            <div class="pricing-plan-description">
								<?php echo html_entity_decode( $pricing_plan->post_content ); ?>
                            </div>
                            <div class="pricing-plan-info">
                                <p><?php echo esc_attr( $meta['listing_limit'] ); ?> <?php esc_html_e( 'Listings', 'motors' ); ?></p>
                                <p><?php echo esc_attr( $meta['feature_limit'] ); ?> <?php esc_html_e( 'Features', 'motors' ); ?></p>
                                <p><?php echo esc_attr( $meta['duration'] ); ?> <?php echo esc_attr( $meta['duration_type'] ); ?> <?php esc_html_e( 'Duration', 'motors' ); ?></p>
                                <p><?php esc_html_e( 'Status:', 'motors' ); ?> <?php echo esc_attr( $meta['status'] ); ?></p>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
        </div>

		<?php if ($data['payment_type'] == \uListing\Lib\PricingPlan\Classes\StmPricingPlans::PRICING_PLANS_PAYMENT_TYPE_SUBSCRIPTION AND uListing_subscription_active()):?>
            <div class="payment_right_box">
                <h6><?php esc_html_e( 'Payment Method', 'motors' ); ?></h6>
                <p><?php esc_html_e( 'All transactions are secure and encrypted.', 'motors' ); ?></p>
                <div class="payment_methods">
					<?php
					$payment_methods = StmPaymentMethod::get_active_payment_method_list(StmPaymentMethod::SUPPORT_SUBSCRIPTION);
					foreach ($payment_methods as $payment_method):?>
						<?php
						$payment_script['selected'].= $payment_method->get_payment_script('selectd');
						$payment_script['buy'].= $payment_method->get_payment_script('buy');
						$payment_script['send_request'].= $payment_method->get_payment_script('send_request');
						$payment_script['success'].= $payment_method->get_payment_script('success');
						?>
                        <div class="payment_method">
                            <label>
                                <input type="radio" v-model="payment_method" v-bind:value="'<?php echo esc_attr($payment_method->id);?>'" />
                                <img style="max-width: 120px" src="<?php echo esc_url( $payment_method->icon)?>" />
                            </label>
							<?php echo html_entity_decode($payment_method->get_payment_form())?>
                        </div>
					<?php endforeach;?>
                </div>
                <div v-if="!payment_loading" class="text-right">
                    <button class="btn-success" @click="buy"><?php esc_html_e( 'Buy plan', 'motors' )?></button>
                </div>
            </div>
		<?php endif;?>

		<?php if ($data['payment_type'] == \uListing\Lib\PricingPlan\Classes\StmPricingPlans::PRICING_PLANS_PAYMENT_TYPE_ONE_TIME):?>
            <div class="payment_right_box">
                <h6><?php esc_html_e( 'Payment Method', 'motors' ); ?></h6>
                <p><?php esc_html_e( 'All transactions are secure and encrypted.', 'motors' ); ?></p>
                <div class="payment_methods">
					<?php
					$payment_methods = StmPaymentMethod::get_active_payment_method_list(StmPaymentMethod::SUPPORT_ONE_TIME_PAYMENT);
					foreach ($payment_methods as $payment_method):?>
						<?php
						$payment_script['selected'].= $payment_method->get_payment_script('selectd');
						$payment_script['buy'].= $payment_method->get_payment_script('buy');
						$payment_script['send_request'].= $payment_method->get_payment_script('send_request');
						$payment_script['success'].= $payment_method->get_payment_script('success');
						?>
                        <div class="payment_method">
                            <label>
                                <input type="radio" class="input-radio" v-model="payment_method" v-bind:value="'<?php echo esc_attr($payment_method->id);?>'" />
                                <img style="max-width: 120px" src="<?php echo esc_url($payment_method->icon)?>" />
                            </label>
							<?php echo html_entity_decode($payment_method->get_payment_form())?>
                        </div>
					<?php endforeach;?>
                </div>
                <div v-if="!payment_loading" class="text-right">
                    <button class="btn-success" @click="buy"><?php esc_html_e( 'Buy plan', 'motors' )?></button>
                </div>
            </div>
		<?php endif;?>

    </div>

    <div v-if="errors" class="text-center">
        <ul>
            <li v-for="error in errors">
                {{error}}
            </li>
        </ul>
    </div>

    <div v-if="message" class="text-center">
        <p>{{message}}</p>
    </div>

    <div v-if="payment_loading" class="text-center">
        <div class="stm-spinner"> <div></div> <div></div> <div></div> <div></div> <div></div> </div>
    </div>
</div>

<?php
wp_add_inline_script(
	"stm-pricing-plan",
    "  
            function ulisting_pricing_plan_payment_selectd(pricing_plan_payment){
                ".$payment_script['selected']."
            }
            function ulisting_pricing_plan_payment_buy(pricing_plan_payment){
                ".$payment_script['buy']."
            }
            function ulisting_pricing_plan_payment_send_request(pricing_plan_payment){
                ".$payment_script['send_request']."
            }
            function ulisting_pricing_plan_payment_success(pricing_plan_payment, response){
                ".$payment_script['success']."
            }
           var stm_payment_data = json_parse('". ulisting_convert_content(json_encode($payment_data)) ."');
	     ",
	"before"
);?>
