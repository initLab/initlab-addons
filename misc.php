<?php
function initlab_automatic_updates_check_vcs(bool $checkout, string $context) {
    if (!$checkout) {
        return $checkout;
    }

    $context = rtrim($context, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $suffix = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
    if (strpos($context, $suffix) === strlen($context) - strlen($suffix)) {
        return false;
    }

    return true;
}

add_action('automatic_updates_is_vcs_checkout', 'initlab_automatic_updates_check_vcs', 10, 2);
