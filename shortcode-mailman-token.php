<?php
function initlab_shortcode_mailman_token($attrs, $content = null) {
    $attrs = shortcode_atts([
        'list_name' => '',
    ], $attrs);

    if (empty($attrs['list_name'])) {
        return '';
    }

    $options = get_option('initlab_options');

    if (
        empty($options) ||
        !array_key_exists('mailman_secret', $options) ||
        !array_key_exists('mailman_version', $options)
    ) {
        return '';
    }

    $now = time();

    if ($options['mailman_version'] === '2.1.16') {
        $remote = $_SERVER['REMOTE_HOST'];

        if (empty($remote)) {
            $remote = $_SERVER['REMOTE_ADDR'];
        }

        if (empty($remote)) {
            $remote = 'w.x.y.z';
        }
    }
    else {
        $remote = $_SERVER['REMOTE_ADDR'];
        $separator = strpos($remote, '.') === false ? ':' : '.';
        $parts = explode($separator, $remote);
        if (count($parts) > 1) {
            array_pop($parts);
        }
        $remote = implode($separator, $parts);
    }

    // TODO
    $captchaIdx = '';

    switch ($options['mailman_version']) {
        case '2.1.16':
        case '2.1.21':
            $str = $options['mailman_secret'] . $now . $attrs['list_name'] . $remote;
            break;
        case '2.1.27':
            $str = $options['mailman_secret'] . ':' . $now . ':' . $attrs['list_name'] . ':' . $remote;
            break;
        case '2.1.30':
            $str = $options['mailman_secret'] . ':' . $now . ':' . $captchaIdx . ':' . $attrs['list_name'] . ':' . $remote;
            break;
        default:
            return '';
    }

    $hash = sha1($str);

    switch ($options['mailman_version']) {
        case '2.1.16':
        case '2.1.21':
        case '2.1.27':
            $token = $now . ':' . $hash;
            break;
        case '2.1.30':
            $token = $now . ':' . $captchaIdx . ':' . $hash;
            break;
        default:
            return '';
    }

    return '<input type="hidden" name="sub_form_token" value="' . $token . '">';
}

add_shortcode('initlab_mailman_token', 'initlab_shortcode_mailman_token');
