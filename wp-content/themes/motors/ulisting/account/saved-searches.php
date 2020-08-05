<?php
/**
 * Account dashboard
 *
 * Template can be modified by copying it to yourtheme/ulisting/account/dashboard.php.
 **
 * @see     #
 * @package uListing/Templates
 * @version 1.0
 */
use uListing\Classes\StmListingTemplate;
use uListing\Classes\StmUser;

$user = new StmUser( $user );
?>

<?php StmListingTemplate::load_template( 'account/navigation', ['user' => $user], true );?>

<div class="my-account">
	<div class="stm-row">
		<div class="stm-col-12">
			<?php do_action( 'ulisting-saved-searches-render-page' ); ?>
		</div>
	</div>
</div>
