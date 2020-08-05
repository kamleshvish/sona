<?php
/**
 * Account login
 *
 * Template can be modified by copying it to yourtheme/ulisting/account/login.php.
 **
 * @see     #
 * @package uListing/Templates
 * @version 1.3.3
 */
wp_enqueue_script('stm-login', ULISTING_URL . '/assets/js/frontend/stm-login.js', array('vue'), ULISTING_VERSION, true);
?>

<div id="stm-listing-login">

    <div class="ulisting-form-gruop" data-v-bind_class="{error: errors['login']}">
        <label> <?php echo esc_html__('Login', 'motors'); ?></label>
        <input type="text"
               data-v-on_keyup.enter="logIn"
               data-v-model="login"
               class="form-control"
               placeholder="<?php esc_html_e('Enter login', 'motors'); ?>"/>
        <span data-v-if="errors['login']" style="color: red">{{errors['login']}}</span>
    </div>

    <div class="ulisting-form-gruop" data-v-bind_class="{error: errors['password']}">
        <label> <?php echo esc_html__('Password', 'motors'); ?></label>
        <input type="password"
               data-v-on_keyup.enter="logIn"
               data-v-model="password"
               class="form-control"
               placeholder="<?php esc_html_e('Enter password', 'motors'); ?>"/>
        <span data-v-if="errors['password']" style="color: red">{{errors['password']}}</span>
    </div>

    <div class="ulisting-form-gruop">
        <div class="stm-row">
            <div class="stm-col">
                <label>
                    <input type="checkbox" value="1" data-v-bind_true-value="1" data-v-bind_false-value="0"
                           data-v-model="remember"> <?php esc_html_e('Remember me', 'motors') ?>
                </label>
            </div>
            <div class="stm-col"><a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password</a></div>
        </div>
    </div>
    <div class="ulisting-form-gruop">
        <button data-v-on_click="logIn" type="button"
                class="btn btn-primary w-full"><?php echo esc_html__('Login', 'motors'); ?></button>
    </div>
    <div data-v-if="loading">Loading...</div>
    <div data-v-if="message" data-v-bind_class="status">{{message}}</div>
</div>

<?php
    $view = apply_filters('usl_social_login_view', '');
    echo stm_do_lmth($view);
?>

