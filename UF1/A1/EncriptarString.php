<?php

$sp = "kfhxivrozziuortghrvxrrkcrozxlwflrh";
$mr = " hv ovxozwozv vj o vfrfjvivfj h vmzvlo e hrxvhlmov oz ozx.vw z xve hv loqvn il hv lmnlg izxvwrhrvml ,hv b lh mv,rhhv mf w zrxvlrh.m";

$alphabet = range( 'a' ,'z');
$reverse_alphabet = array_reverse( $alphabet );

echo decrypt($sp);
echo "<br>";
echo decrypt($mr);
echo "<br>";
echo "<br>";

$text = "vull encriptar aquest text, molt bona tarda";

echo $text;
echo "<br>";


$cipher="AES-128-CBC";
$key = openssl_pkey_new();
$ivlen = openssl_cipher_iv_length( $cipher );
$iv = openssl_random_pseudo_bytes( $ivlen );
$encrypted_text = openssl_encrypt($text, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);

echo $encrypted_text;
echo "<br>";

$decripted_text = openssl_decrypt($encrypted_text, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);

echo $decripted_text;
echo "<br>";
echo "<br>";

$text_original = "aquest es un text que he encrpitat de forma propia i originial";
echo $text_original;
echo "<br>";

$key_original = "172.24.4.141";
echo $key_original;
echo "<br>";
echo "<br>";

$encrypted_original_text = encrypt_original( $text_original, $key_original);
echo $encrypted_original_text;
echo "<br>";
echo "<br>";

$decripted_original_text = decrypt_original( $encrypted_original_text, $key_original);
echo $decripted_original_text;
echo "<br>";

function decrypt( $encrypted_string ) {
    $string_array = str_split( $encrypted_string, 3 );
    foreach ( $string_array as $string ) {
        $string = strrev( $string );
        $string = reverse( $string );
        echo "$string";
    }
}

function reverse( $input ) {
    $string = "";
    $string_array = str_split($input);
    global $alphabet, $reverse_alphabet;
    foreach ( $string_array as $character ) {
        $position = array_search( $character, $alphabet );
        if ( $position == false) {
            $string .= $character;
        } else {
            $character = $reverse_alphabet[$position];
            $string .= $character;
        }
    }
    return $string;
}

function encrypt_original ( $text, $key ) {
    global $alphabet;

    $encrypted_original_text = "";
    $splited_key = explode(".", $key);
    $splited_text = str_split($text);
    $key_pos = 0;

    foreach ( $splited_text as $character ) {
        $char_value = mb_ord($character, "utf8");
        $char_value = ($char_value + $splited_key[$key_pos]) * count($splited_key);
        $key_pos++;

        if ( $key_pos >= count($splited_key)) $key_pos = 0;

        $encrypted_original_text .= base_convert($char_value, 10, 36);
    }
    
    return $encrypted_original_text;
}

function decrypt_original ( $encrypted_text, $key ) {
    global $alphabet;

    $decrypted_original_text = "";
    $splited_key = explode(".", $key);
    $splited_text = str_split($encrypted_text, 2);
    $key_pos = 0;

    foreach ( $splited_text as $character ) {
        $char_value = base_convert($character, 36, 10);
        $char_value = $char_value / count($splited_key) - $splited_key[$key_pos];
        $key_pos++;

        if ( $key_pos >= count($splited_key)) $key_pos = 0;

        $decrypted_original_text .= mb_chr($char_value);
    }

    return $decrypted_original_text;
}
?>