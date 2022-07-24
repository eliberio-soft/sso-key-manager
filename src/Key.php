<?php

namespace Eliberiosoft\SsoKeyManager;

class Key
{
    public string $privateKey;

    public string $publicKey;

    public string $randomNonce;

    /**
     * @param  string  $privateKey
     * @return Key
     */
    public function setPrivateKey(string $privateKey): Key
    {
        $this->privateKey = rawurlencode(base64_encode($privateKey));

        return $this;
    }

    /**
     * @param  string  $publicKey
     * @return Key
     */
    public function setPublicKey(string $publicKey): Key
    {
        $this->publicKey = rawurlencode(base64_encode($publicKey));

        return $this;
    }

    /**
     * @param  string  $randomNonce
     * @return Key
     */
    public function setRandomNonce(string $randomNonce): Key
    {
        $this->randomNonce = rawurlencode(base64_encode($randomNonce));

        return $this;
    }
}
