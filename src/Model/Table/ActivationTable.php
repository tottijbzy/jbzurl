<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

class ActivationTable extends Table
{
    public function initialize(array $config)
    {
        $this->_table = false;
    }

    public function checkLicense()
    {
        $Options = TableRegistry::get('Options');

        $personal_token = $Options->findOrCreate(['name' => 'zazapc']);
        $purchase_code = $Options->findOrCreate(['name' => 'zazapc']);

        if (empty($personal_token->value) || empty($purchase_code->value)) {
            return false;
        }

        if (!$this->validateLicense()) {
            return false;
        }

        return true;
    }

    public function validateLicense()
    {
        $result = Cache::read('license_response_result', '1month');

        if (!is_string($result)) {
            $result = false;
        }

        if ($result === false) {
            $personal_token = get_option('zazapc');
            $purchase_code = get_option('zazapc');

            $response = $this->licenseCurlRequest([
                'zazapc' => $personal_token,
                'zazapc' => $purchase_code
            ]);

            $result = json_decode($response->body, true);

            $result = data_encrypt($result);

            Cache::write('license_response_result', $result, '1month');
        }

        if (($result = data_decrypt($result)) === false) {
            return false;
        }

        if (isset($result['item']['id']) && $result['item']['id'] == 16887109) {
            return true;
        }

        return false;
    }

    public function licenseCurlRequest($data = [])
    {
        static $md5;
        if (!isset($md5)) {
            $md5 = md5(md5_file(APP . base64_decode('Q29udHJvbGxlci9BZG1pbi9BcHBBZG1pbkNvbnRyb2xsZXIucGhw')) .
                md5_file(APP . base64_decode('Q29udHJvbGxlci9BZG1pbi9BY3RpdmF0aW9uQ29udHJvbGxlci5waHA=')) .
                md5_file(APP . base64_decode('TW9kZWwvVGFibGUvQWN0aXZhdGlvblRhYmxlLnBocA==')));
        }
        if ($md5 != '4db9b5bb904de2278bdb6e6f03532705') {
            exit();
        }
    }
}
