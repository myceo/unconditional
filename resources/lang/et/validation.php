<?php 

return [
    'between' => [
        'numeric' => 'Atribuut :attribute peab olema vahemikus :min ja :max.',
        'file' => 'Atribuut :attribute peab olema vahemikus :min ja :max kilobaiti.',
        'string' => 'Atribuut :attribute peab jääma märkide :min ja :max vahele.',
        'array' => 'Atribuudi :attribute üksused peavad olema vahemikus :min kuni :max',
    ],
    'boolean' => 'Atribuudi väli peab olema tõene või vale.',
    'confirmed' => 'Atribuudi kinnitus ei kattu.',
    'dimensions' => 'Atribuudil on valed kujutise mõõtmed.',
    'distinct' => 'Atribuudi väljal on duplikaatväärtus.',
    'filled' => 'Atribuudi väljal peab olema väärtus.',
    'gt' => [
        'numeric' => ':attribute peab olema suurem kui :value.',
        'file' => 'Atribuut :attribute olema suurem kui :value kilobaiti.',
        'string' => ':attribute peab olema suurem kui :value märke.',
        'array' => 'Atribuudil :attribute peab olema rohkem kui :value üksusi.',
    ],
    'gte' => [
        'numeric' => 'Atribuut :attribute peab olema suurem kui :value. või sellega võrdne.',
        'file' => 'Atribuut :attribute peab olema suurem või võrdne väärtusega kilobaiti.',
        'string' => 'Atribuut :attribute peab olema suurem kui :value märk või sellega võrdne.',
        'array' => 'Atribuudil :attribute peab olema :value üksusi või rohkem.',
    ],
    'lt' => [
        'numeric' => 'Atribuut :attribute peab olema väiksem kui :value.',
        'file' => 'Atribuut :attribute peab olema väiksem kui :value kilobaiti.',
        'string' => ':attribute peab olema väiksem kui :value märke.',
        'array' => 'Atribuudis :attribute peab olema vähem kui :value üksusi.',
    ],
    'lte' => [
        'numeric' => 'Atribuut :attribute peab olema väärtusest väiksem või sellega võrdne.',
        'file' => 'Atribuut :attribute peab olema väiksem kui :value kilobait või sellega võrdne.',
        'string' => 'Atribuut :attribute peab olema :value märkidest väiksem või sellega võrdne.',
        'array' => 'Atribuudis :attribute ei tohi olla rohkem kui :value üksusi.',
    ],
    'max' => [
        'numeric' => 'Atribuut :attribute ei tohi olla suurem kui :max.',
        'file' => 'Atribuut : ei tohi olla suurem kui :attribute kilobaiti.',
        'string' => 'Atribuut :attribute ei tohi olla suurem kui :max tähemärki.',
        'array' => 'Atribuudis :attribute ei tohi olla rohkem kui :max üksusi.',
    ],
    'min' => [
        'numeric' => 'Atribuut :attribute peab olema vähemalt :min.',
        'file' => ':attribute peab olema vähemalt :min kilobaiti.',
        'string' => 'Atribuut :attribute peab sisaldama vähemalt :min märke.',
        'array' => ':attribute peab sisaldama vähemalt :min üksusi.',
    ],
    'not_regex' => 'Atribuudi vorming on vale.',
    'present' => 'Atribuudi väli peab olema olemas.',
    'regex' => 'Atribuudi vorming on vale.',
    'required' => 'Atribuudi väli on kohustuslik.',
    'required_without_all' => 'Atribuudi väli on nõutav, kui ühtegi väärtust pole.',
    'size' => [
        'numeric' => ':attribute peab olema :size.',
        'file' => ':attribute peab olema :size kilobaiti.',
        'string' => ':attribute peab olema :size tähemärki.',
        'array' => 'Atribuut :attribute peab sisaldama :size üksusi.',
    ],
    'uploaded' => 'Atribuuti ei õnnestunud üles laadida.',
    'url' => 'Atribuudi vorming on vale.',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'kohandatud teade',
        ],
    ],
    'attributes' => '',
    'accepted' => ':attribute tuleb aktsepteerida.',
    'active_url' => 'Atribuut :attribute ei ole kehtiv URL.',
    'after' => 'Atribuut :attribute peab olema kuupäev pärast :date.',
    'after_or_equal' => 'Atribuut :attribute peab olema kuupäev pärast :date. või sellega võrdne.',
    'alpha' => 'Atribuut : võib sisaldada ainult tähti.',
    'alpha_dash' => 'Atribuut : võib sisaldada ainult tähti, numbreid, sidekriipse ja alakriipse.',
    'alpha_num' => 'Atribuut : võib sisaldada ainult tähti ja numbreid.',
    'array' => 'Atribuut :attribute peab olema massiiv.',
    'before' => 'Atribuut :attribute peab olema kuupäev enne :date.',
    'before_or_equal' => 'Atribuut :attribute peab olema kuupäev, mis on enne :date. või sellega võrdne.',
    'date' => ':attribute ei ole kehtiv kuupäev.',
    'date_equals' => 'Atribuut :attribute peab olema kuupäev, mis on võrdne atribuudiga :date.',
    'date_format' => 'Atribuut :attribute ei vasta vormingule :format.',
    'different' => ':attribute ja :other peavad olema erinevad.',
    'digits' => 'Atribuut :attribute peab olema :digits numbrid.',
    'digits_between' => 'Atribuut :attribute peab jääma numbrite :min ja :max vahele.',
    'email' => 'Atribuut :attribute peab olema kehtiv e-posti aadress.',
    'ends_with' => 'Atribuut :attribute peab lõppema ühega järgmistest: :values',
    'exists' => 'Valitud :attribute on kehtetu.',
    'file' => 'Atribuut :attribute peab olema fail.',
    'image' => 'Atribuut :attribute peab olema pilt.',
    'in' => 'Valitud :attribute on kehtetu.',
    'in_array' => 'Välja :attribute ei eksisteeri :other.',
    'integer' => 'Atribuut : peab olema täisarv.',
    'ip' => 'Atribuut :attribute peab olema kehtiv IP-aadress.',
    'ipv4' => 'Atribuut :attribute peab olema kehtiv IPv4-aadress.',
    'ipv6' => 'Atribuut :attribute peab olema kehtiv IPv6-aadress.',
    'json' => 'Atribuut :attribute peab olema kehtiv JSON-string.',
    'mimes' => 'Atribuut :attribute peab olema faili tüüpi: :values.',
    'mimetypes' => 'Atribuut :attribute peab olema faili tüüpi: :values.',
    'not_in' => 'Valitud :attribute on kehtetu.',
    'numeric' => 'Atribuut :attribute peab olema arv.',
    'required_if' => 'Väli :attribute on kohustuslik, kui :other on :value.',
    'required_unless' => 'Väli :attribute on kohustuslik, välja arvatud juhul, kui :other on jaotises :values.',
    'required_with' => 'Väli :attribute on kohustuslik, kui :values ​​on olemas.',
    'required_with_all' => 'Väli :attribute on kohustuslik, kui :values ​​on olemas.',
    'required_without' => 'Väli :attribute on kohustuslik, kui :values ​​puudub.',
    'same' => ':attribute ja :other peavad ühtima.',
    'starts_with' => 'Atribuut :attribute peab algama ühega järgmistest: :values',
    'string' => 'Atribuut :attribute peab olema string.',
    'timezone' => 'Atribuut :attribute peab olema kehtiv tsoon.',
    'unique' => 'Atribuut : on juba võetud.',
    'uuid' => 'Atribuut :attribute peab olema kehtiv UUID.',
    'captcha' => 'Sisestatud vale captcha-kood. Kontrollige koodi ja proovige uuesti.',
];