<?php

namespace Eliberiosoft\SsoKeyManager;

class SodiumManager
{
    private Key $key;

    private string $toTransform;

    /**
     * @throws \SodiumException
     * @throws \Exception
     */
    public function generatePrivatePublicKey(): Key
    {
        $keypair = sodium_crypto_box_keypair();
        $this->key = (new Key())
            ->setPrivateKey(sodium_crypto_box_secretkey($keypair))
            ->setPublicKey(sodium_crypto_box_publickey($keypair))
            ->setRandomNonce(random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES));

        return $this->key;
    }

    public function stringToProcess(string $toTransform): self
    {
        $this->toTransform = $toTransform;

        return $this;
    }

    private function originalByte(string $toProcess): bool|string
    {
        return base64_decode(rawurldecode($toProcess));
    }

    /**
     * @throws \SodiumException
     */
    public function encrypted(string $secretKey, string $publicKey, string $randomNonce): string
    {
        $senderKeypair = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            $this->originalByte($secretKey), $this->originalByte($publicKey)
        );

        return sodium_crypto_box($this->toTransform, $this->originalByte($randomNonce), $senderKeypair);
    }

    /**
     * @throws \SodiumException
     */
    public function decrypted(string $secretKey, string $publicKey, string $randomNonce): string
    {
        $recipientKeypair = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            $this->originalByte($secretKey), $this->originalByte($publicKey)
        );

        return sodium_crypto_box_open($this->toTransform, $this->originalByte($randomNonce), $recipientKeypair);
    }
}
