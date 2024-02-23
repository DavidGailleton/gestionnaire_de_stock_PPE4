<?php

namespace ppe4;

class JWT
{
    /**
     * Génère le tableau de données nécessaire à la création du JWT
     *
     * @param string $id
     * @param string $email
     * @param Role $role
     * @return array
     */
    public function generate_payload(string $id, string $email, Role $role):array
    {
        return [
            'user_id' => $id,
            'user_email' => $email,
            'user_role' => $role->getLibelle()
        ];
    }

    /**
     * Génère le JWT sous forme de chaine de caractère
     *
     * @param array $payload
     * @param int $validity
     * @return string
     */
    public function generate(array $payload, int $validity = 14400):string
    {

        if($validity > 0){
            $now = new \DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;
        }

        $base_64_header = base64_encode(json_encode(JWT_HEADER));
        $base_64_payload = base64_encode(json_encode($payload));

        // suppression et remplacement des caracteres interdit pour JWT
        $base_64_header = str_replace(['+', '/', '='], ['-', '_', ''], $base_64_header);
        $base_64_payload = str_replace(['+', '/', '='], ['-', '_', ''], $base_64_payload);

        //generation de la signature
        $secret = base64_encode(JWT_SECRET);
        $signature = hash_hmac('sha256', $base_64_header.'.'.$base_64_payload, $secret, true);

        $base_64_signature = base64_encode($signature);
        $base_64_signature = str_replace(['+', '/', '='], ['-', '_', ''], $base_64_signature);

        //generation du token
        $jwt = $base_64_header.'.'.$base_64_payload.'.'.$base_64_signature;

        return $jwt;
    }

    /**
     * Vérifie si le token JWT est valide
     *
     * @param string $token
     * @return bool
     */
    public function check(string $token):bool
    {
        $payload = $this->get_payload($token);

        $verif_token = $this->generate((array)$payload, 0);

        return $token === $verif_token;
    }

    /**
     * Récupère le header contenue dans le token JWT
     *
     * @param string $token
     * @return array
     */
    public function get_header(string $token):array
    {
        $array = explode('.', $token);
        $header = $array[0];

        return json_decode(base64_decode($header), true);
    }

    /**
     * Récupère le payload contenue dans le token JWT
     *
     * @param string $token
     * @return array
     */
    public function get_payload(string $token):array
    {
        $array = explode('.', $token);
        $payload = $array[1];

        return json_decode(base64_decode($payload), true);
    }

    /**
     * Vérifie si le token JWT est expiré
     *
     * @param string $token
     * @return bool
     */
    public function is_expired(string $token):bool
    {
        $payload = $this->get_payload($token);

        $now = new \DateTime();

        return ($payload['exp'] < $now->getTimestamp());
    }

    /**
     * Vérifie si le token JWT est conforme aux normes JWT
     *
     * @param string $token
     * @return bool
     */
    public function is_valid(string $token):bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-_=]+\.[a-zA-Z0-9\-_=]+\.[a-zA-Z0-9\-_=]+$/',
                $token
        ) === 1;

    }
}