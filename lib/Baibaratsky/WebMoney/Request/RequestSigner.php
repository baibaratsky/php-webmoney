<?php
namespace Baibaratsky\WebMoney\Request;

use Baibaratsky\WebMoney\Exception\RequestSignerException;

/**
 * Class RequestSigner
 */
class RequestSigner
{
    private $_power, $_modulus;

    /**
     * Create RequestSigner object
     *
     * @param string $wmid          WMID
     * @param string $keyFileName   Full path to the key file
     * @param string $keyPassword   Key file password
     *
     * @throws RequestSignerException
     */
    public function __construct($wmid, $keyFileName, $keyPassword)
    {
        if (empty($wmid)) {
            throw new RequestSignerException('WMID not provided.');
        }

        if (!file_exists($keyFileName)) {
            throw new RequestSignerException('Key file not found: ' . $keyFileName);
        }
        $key = file_get_contents($keyFileName);

        $keyData = unpack('vreserved/vsignFlag/a16hash/Vlength/a*buffer', $key);
        $keyData['buffer'] = $this->_encryptKey($keyData['buffer'], $wmid, $keyPassword);

        if (!$this->_verifyHash($keyData)) {
            throw new RequestSignerException('Hash check failed. Key file seems corrupted.');
        }

        $this->_initSignVariables($keyData['buffer']);
    }

    /**
     * Create signature for given data
     *
     * @param string $data
     *
     * @return string
     */
    public function sign($data)
    {
        // Make data hash (16 bytes)
        $base = hash('md4', $data, true);

        // Add 40 random bytes
        for ($i = 0; $i < 10; ++$i) {
            $base .= pack('V', mt_rand());
        }

        // Add length of the base as first 2 bytes
        $base = pack('v', strlen($base)) . $base;

        // Modular exponentiation
        $dec = bcpowmod($this->_rev2dec($base), $this->_power, $this->_modulus);

        // Convert result to hexadecimal
        $hex = gmp_strval($dec, 16);

        // Fill empty bytes with zeros
        $hex = str_repeat('0', 132 - strlen($hex)) . $hex;

        // Reverse byte order
        $hexReversed = '';
        for ($i = 0; $i < strlen($hex) / 4; ++$i) {
            $hexReversed = substr($hex, $i * 4, 4) . $hexReversed;
        }

        return strtolower($hexReversed);
    }

    /**
     * Encrypt key using hash of WMID and key password
     *
     * @param string $keyBuffer
     * @param string $wmid
     * @param string $keyPassword
     *
     * @return string
     */
    private function _encryptKey($keyBuffer, $wmid, $keyPassword)
    {
        $hash = hash('md4', $wmid . $keyPassword, true);

        return $this->_xor($keyBuffer, $hash, 6);
    }

    /**
     * XOR subject with modifier
     *
     * @param string $subject
     * @param string $modifier
     * @param int $shift
     *
     * @return string
     */
    private function _xor($subject, $modifier, $shift = 0)
    {
        $modifierLength = strlen($modifier);
        $i = $shift;
        $j = 0;
        while ($i < strlen($subject)) {
            $subject[$i] = chr(ord($subject[$i]) ^ ord($modifier[$j]));
            ++$i;
            if (++$j >= $modifierLength) {
                $j = 0;
            }
        }

        return $subject;
    }

    /**
     * Verify hash of the key
     *
     * @param $keyData
     *
     * @return bool
     */
    private function _verifyHash($keyData)
    {
        $verificationString = pack('v', $keyData['reserved'])
            . pack('v', 0)
            . pack('V4', 0, 0, 0, 0)
            . pack('V', $keyData['length'])
            . $keyData['buffer'];
        $hash = hash('md4', $verificationString, true);

        return strcmp($hash, $keyData['hash']) == 0;
    }

    /**
     * Initialize power and modulus to use for signing
     *
     * @param string $keyBuffer
     */
    private function _initSignVariables($keyBuffer)
    {
        $data = unpack('Vreserved/vpowerLength', $keyBuffer);
        $data = unpack('Vreserved/vpowerLength/a' . $data['powerLength'] . 'power/vmodulusLength', $keyBuffer);
        $data = unpack('Vreserved/vpowerLength/a' . $data['powerLength'] . 'power/vmodulusLength/a'
                    . $data['modulusLength'] . 'modulus', $keyBuffer);
        $this->_power = $this->_rev2dec($data['power']);
        $this->_modulus = $this->_rev2dec($data['modulus']);
    }

    /**
     * Reverse byte order and convert binary data to decimal string
     *
     * @param string $binaryData
     *
     * @return string
     */
    private function _rev2dec($binaryData)
    {
        return gmp_strval('0x' . bin2hex(strrev($binaryData)));
    }
}
