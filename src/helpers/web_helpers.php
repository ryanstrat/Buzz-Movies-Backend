
<?php

function buildInterstitialURL($btnText, $btnTarget, $message) {
    $data = array('btnText' => $btnText,
                  'btnTarget' => $btnTarget,
                  'message' => $message );
    
    $query = http_build_query($data);
    return "/interstitial?" . $query;
}