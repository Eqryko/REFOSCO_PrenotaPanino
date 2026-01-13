<?php
$ingredienti = [
        "pane" => [
            "ROT-13" => 3,
            "Integrale AES" => 2.5,
            "IPv4" => 2,
            "IPv6" => 2.5
        ],
        "proteina" => [
            "Manzo Brute Force" => 0,
            "Crispy Triple DES" => 0.5,
            "Veggie XOR Triple DES" => 0.7,
            "Pesce Blowfish Encrypt" => 1,
            "Pollo Fast UDP" => 0.8,
            "Vitello Man-In-the-Middle" => 1.2,
            "Bacon Cipher ABAB" => 1.5,
            "kebab-case" => 1.3
        ],
        "verdura" => [
            "Lattuga S-box" => 0,
            "Carote Diffie-Hellman" => 0.3,
            "Misto SHA2 SHA3" => 0.5,
            "Rucola Trojan (sconsigliata)" => 0.3,
            "Pomodorini Crypto" => 0.2
        ],
        "salsa" => [
            "Salsa20" => 0.5,
            "XSalsa20" => 0.5,
            "Spicy ChaCha" => 0.5,
            "Gnutella" => 0.7,
            "PHP Injection (veg)" => 0.7
        ],
        "aggiunte" => [
            "Patatine Vigenere" => 0.7,
            "Verdura RSA + salsa Hash" => 0.8,
            "flag{Holy_Cyber_Nuggets}" => 0.9,
            "Stream Ciphers Cips" => 1.0
        ]
];

$json = json_encode($ingredienti);
echo $json;

$data = json_decode($json, true);
?>