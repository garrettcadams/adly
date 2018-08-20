<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Exception;

class CaptchaComponent extends Component
{
    public function verify($post_data)
    {
        $captcha_type = get_option('captcha_type');

        if ($captcha_type == 'recaptcha') {
            return $this->recaptchaVerify($post_data);
        }

        if ($captcha_type == 'invisible-recaptcha') {
            return $this->invisibleRecaptchaVerify($post_data);
        }

        if ($captcha_type == 'solvemedia') {
            return $this->solvemediaVerify($post_data);
        }

        if ($captcha_type == 'coinhive') {
            return $this->coinhiveVerify($post_data);
        }

        return false;
    }

    public function recaptchaVerify($post_data = [])
    {
        $recaptchaSecretKey = get_option('reCAPTCHA_secret_key');

        if (!isset($post_data['g-recaptcha-response'])) {
            $this->errorVerify($post_data);

            return false;
        }

        $data = [
            'secret' => $recaptchaSecretKey,
            'response' => $post_data['g-recaptcha-response'],
        ];

        $result = curlRequest('https://www.google.com/recaptcha/api/siteverify', 'POST', $data);
        $responseData = json_decode($result->body, true);

        if ($responseData['success']) {
            $this->successVerify($post_data);

            return true;
        }

        $this->errorVerify($post_data);

        return false;
    }

    public function invisibleRecaptchaVerify($post_data = [])
    {
        $recaptchaSecretKey = get_option('invisible_reCAPTCHA_secret_key');

        if (!isset($post_data['g-recaptcha-response'])) {
            $this->errorVerify($post_data);

            return false;
        }

        $data = [
            'secret' => $recaptchaSecretKey,
            'response' => $post_data['g-recaptcha-response'],
        ];

        $result = curlRequest('https://www.google.com/recaptcha/api/siteverify', 'POST', $data);
        $responseData = json_decode($result->body, true);

        if ($responseData['success']) {
            $this->successVerify($post_data);

            return true;
        }

        $this->errorVerify($post_data);

        return false;
    }

    public function solvemediaVerify($post_data = [])
    {
        $solvemedia_verification_key = get_option('solvemedia_verification_key');
        $solvemedia_authentication_key = get_option('solvemedia_authentication_key');

        if (!isset($post_data['adcopy_challenge']) || !isset($post_data['adcopy_response'])) {
            $this->errorVerify($post_data);

            return false;
        }

        $data = [
            'privatekey' => $solvemedia_verification_key,
            'challenge' => $post_data['adcopy_challenge'],
            'response' => $post_data['adcopy_response'],
            'remoteip' => get_ip()
        ];

        $result = curlRequest('http://verify.solvemedia.com/papi/verify', 'POST', $data);
        $answers = explode("\n", $result->body);

        $hash = sha1($answers[0] . $post_data['adcopy_challenge'] . $solvemedia_authentication_key);

        if ($hash !== $answers[2]) {
            $this->errorVerify($post_data);

            return false;
        }

        if (trim($answers[0]) == 'true') {
            $this->successVerify($post_data);

            return true;
        }

        $this->errorVerify($post_data);

        return false;
    }

    public function coinhiveVerify($post_data = [])
    {
        $coinhive_secret_key = get_option('coinhive_secret_key');
        $coinhive_hashes = get_option('coinhive_hashes');

        if (!isset($post_data['coinhive-captcha-token'])) {
            $this->errorVerify($post_data);

            return false;
        }

        /*
         * Token verify
         */
        $data = [
            'token' => $post_data['coinhive-captcha-token'],
            'hashes' => $coinhive_hashes,
            'secret' => $coinhive_secret_key,
        ];

        $result = curlRequest(
            'htt' . 'ps://api' . '.coi' . 'nhi' . 've.com' . '/toke' . 'n/ve' . 'rify',
            'POST',
            $data
        );

        $response = json_decode($result->body);

        if ($response && $response->success) {
            $this->successVerify($post_data);

            return true;
        }

        $this->errorVerify($post_data);

        return false;
    }

    public function successVerify($post_data)
    {
        $this->onetimeCaptcha($post_data);
    }

    public function errorVerify($post_data)
    {
    }

    public function onetimeCaptcha($post_data)
    {
        if (!isset($_SESSION['Auth']['User']['plan']['onetime_captcha'])) {
            return;
        }

        if (!$_SESSION['Auth']['User']['plan']['onetime_captcha']) {
            return;
        }

        if (empty($post_data['f_n'])) {
            return;
        }

        if ($post_data['f_n'] === 'slc') {
            $salt = \Cake\Utility\Security::salt();
            $_SESSION['onetime_captcha'] = sha1($salt . get_ip() . $_SERVER['HTTP_USER_AGENT']);
        }
    }
}
