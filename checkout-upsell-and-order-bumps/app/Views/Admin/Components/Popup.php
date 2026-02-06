<?php
defined('ABSPATH') || exit;

if (empty($count)) {
    return;
}
?>
<div class="cuw-popup-overlay" id="cuw-sync-popup">
    <div class="cuw-popup">
        <!-- Header -->
        <div class="cuw-popup-header flex justify-between items-center">
            <h2><?php esc_html_e('Synchronize Reports', 'checkout-upsell-and-order-bumps'); ?></h2>
            <span class="cuw-popup-close">×</span>
        </div>

        <!-- Steps -->
        <div class="cuw-popup-steps flex items-center justify-center my-4">
            <div class="step step-1 active">
                <span>1</span>
                <p><?php esc_html_e('Preview', 'checkout-upsell-and-order-bumps'); ?></p>
            </div>
            <div class="step-line"></div>
            <div class="step step-2">
                <span>2</span>
                <p><?php esc_html_e('Processing', 'checkout-upsell-and-order-bumps'); ?></p>
            </div>
        </div>

        <!-- Step 1 (Preview) -->
        <div class="cuw-popup-body step-content step-1-content text-center">
            <div class="cuw-total-box">
                <p><?php esc_html_e('Total Items', 'checkout-upsell-and-order-bumps'); ?></p>
                <span class="cuw-total-count"><?php echo esc_html($count); ?></span>
            </div>
        </div>

        <!-- Step 2 (Processing/Completed) -->
        <div class="cuw-popup-body step-content step-2-content text-center hidden">
            <div class="cuw-total-box">
                <p class="cuw-total-head-text"><?php esc_html_e('Processed Items', 'checkout-upsell-and-order-bumps'); ?></p>
                <div class="w-full mt-6 space-y-4" style="width: 100%">
                    <!-- Progress bar wrapper -->
                    <div class="cuw-reports-progress-bar-percentage"></div> <!-- separate % text -->
                    <div class="cuw-reports-progress-bar-container w-full bg-gray-200 rounded-full h-4">
                        <div class="progress-bar text-center bg-blue-600 h-4 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                             id="cuw-progress-bar"
                             style="width:0%">
                        </div>
                    </div>


                    <!-- Counters -->
                    <div class="flex justify-between mt-2 text-sm text-gray-800 cuw-reports-sync-compt-text">
                        <?php
                        printf(
                                /* translators: %1$s is the number of items processed, %2$s is the total number of items. */
                                esc_html__('%1$s of %2$s completed', 'checkout-upsell-and-order-bumps'),
                                '<span class="processed-count">0</span>',
                                '<span class="total-count">' . esc_html($count) . '</span>'
                        );
                        ?>
                    </div>
                    <!-- Retry Button -->
                    <div class="w-100 align-items-center justify-content-end d-flex">
                        <button class="btn btn-primary d-none" id="cuw-stats-retry-btn"><?php echo esc_html__('Retry','checkout-upsell-and-order-bumps'); ?></button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="cuw-popup-footer flex justify-end mt-6">
            <button type="button" id="cuw-reports-next-btn" class="btn btn-primary">
                <?php esc_html_e('Next', 'checkout-upsell-and-order-bumps'); ?>
            </button>
        </div>
    </div>
</div>

<!-- Close Confirmation Modal -->
<div id="cuw-close-confirm" class="cuw-reports-sync-close-popup hidden">
    <div>
        <h3 >
            <?php esc_html_e('Process is not complete. Do you want to exit?', 'checkout-upsell-and-order-bumps'); ?>
        </h3>
        <div >
            <button id="cuw-reports-sync-close-no">
                <?php esc_html_e('No', 'checkout-upsell-and-order-bumps'); ?>
            </button>
            <button id="cuw-reports-sync-close-yes">
                <?php esc_html_e('Yes', 'checkout-upsell-and-order-bumps'); ?>
            </button>
        </div>
    </div>
</div>
