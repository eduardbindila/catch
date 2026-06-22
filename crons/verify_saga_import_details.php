<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_format.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_functions.php');

//var_dump($_GET);

if ($_GET["type"] == 4) {
    $checkBody = checkJson($clientInvoicesData, 'iesiri');
    $clientJson = json_decode($clientsJson, true);
    $requestJson = ['iesiri' => $clientInvoicesQuery];

} elseif ($_GET["type"] == 5) {
     $checkBody = checkJson($vendorInvoicesData, 'intrari');
     $vendorJson = json_decode($vendorsJson, true);
     $requestJson = ['intrari' => $vendorInvoicesQuery];
}


$checkJson = json_encode($checkBody);



//var_dump($clientInvoicesData);

// $url = requestUrl('verificare', $target);

// $sagaRequest = callSaga($url, $checkJson);


// $notificationId = $sagaRequest['notificationId'];

// if($notificationId > 0) {
// 	sleep(2);
// 	$sagaCheckImportStatus = checkNotificationId($notificationId);	
// } else {
// 	$sagaCheckImportStatus = 0;
// }

// // Decodează stringurile JSON în array-uri PHP
// $sagaCheckImportStatus = json_decode($sagaCheckImportStatus, true);
// $productsJson = json_decode($productsJson, true);

//     $response = [
//         'checkJson' => $sagaCheckImportStatus,
//         'productsJson' => $productsJson,
//         'clientJson' => isset($clientJson) ? $clientJson : [],
//         'vendorJson' => isset($vendorJson) ? $vendorJson : [],
//     ];

    // Encodează array-ul de răspuns în JSON
    //echo json_encode($response);


/* ==== CONFIG FIRMA (completează cu datele tale) ==== */
$COMPANY = [
  'name' => 'SC Icatch Design S.R.L.',

  'cif'  => 'RO33302129',
];

/* ==== HELPERS GENERALE ==== */
function arr_get($a,$k,$d=''){ return isset($a[$k])?$a[$k]:$d; }
function arr_get_any($a, array $keys, $default = ''){
  foreach ($keys as $key) {
    if (isset($a[$key])) {
      return $a[$key];
    }
  }
  return $default;
}
function ymd($s){ $t=strtotime($s); return $t?date('Y-m-d',$t):$s; }
function normProcTva($v){ if($v===''||$v===null)return ''; $v=(float)$v; return $v<1? (string)round($v*100,2) : (string)$v; }
function addEl(DOMDocument $doc, DOMElement $parent, string $name, $val){
  if($val===null) return; $val=is_string($val)?trim($val):$val;
  if($val === '' && $name!=='TVA' && $name!=='ProcTVA') return; // trimite TVA=0 când există
  $parent->appendChild($doc->createElement($name, $val));
}

/* ==== EXPORT NOMENCLATOARE ==== */
function exportFurnizoriXML(array $furnizori, string $filePath){
  $doc=new DOMDocument('1.0','UTF-8'); $doc->formatOutput=true;
  $root=$doc->appendChild($doc->createElement('Furnizori'));
  foreach($furnizori as $f){
    $lin=$root->appendChild($doc->createElement('Linie'));
    addEl($doc,$lin,'Cod',       arr_get($f,'cod'));
    addEl($doc,$lin,'Denumire',  arr_get($f,'denumire'));
    addEl($doc,$lin,'Cod_fiscal',arr_get($f,'codFiscal')); // dacă îl ai
    addEl($doc,$lin,'Tara',      arr_get($f,'tara'));
    addEl($doc,$lin,'Localitate',arr_get($f,'localitate'));
    addEl($doc,$lin,'Adresa',    arr_get($f,'adresa'));
    addEl($doc,$lin,'Cont_banca',arr_get($f,'contBanca'));
    addEl($doc,$lin,'Banca',     arr_get($f,'banca'));
    addEl($doc,$lin,'Tel',       arr_get($f,'tel'));
    addEl($doc,$lin,'Email',     arr_get($f,'email'));
  }
  $doc->save($filePath);
}

function exportClientiXML(array $clienti, string $filePath){
  $doc=new DOMDocument('1.0','UTF-8'); $doc->formatOutput=true;
  $root=$doc->appendChild($doc->createElement('Clienti'));
  foreach($clienti as $c){
    $lin=$root->appendChild($doc->createElement('Linie'));
    addEl($doc,$lin,'Cod',       arr_get($c,'cod'));
    addEl($doc,$lin,'Denumire',  arr_get($c,'denumire'));
    addEl($doc,$lin,'Cod_fiscal',arr_get($c,'codFiscal'));
    addEl($doc,$lin,'Reg_com',   arr_get($c,'regCom'));
    addEl($doc,$lin,'Tara',      arr_get($c,'tara'));
    addEl($doc,$lin,'Judet',     arr_get($c,'judet'));
    addEl($doc,$lin,'Localitate',arr_get($c,'localitate'));
    addEl($doc,$lin,'Adresa',    arr_get($c,'adresa'));
    addEl($doc,$lin,'Cont_banca',arr_get($c,'contBanca'));
    addEl($doc,$lin,'Banca',     arr_get($c,'banca'));
    addEl($doc,$lin,'Tel',       arr_get($c,'tel'));
    addEl($doc,$lin,'Email',     arr_get($c,'email'));
    addEl($doc,$lin,'Discount',  arr_get($c,'discount'));
  }
  $doc->save($filePath);
}

function exportArticoleXML(array $articole, string $filePath){
  $doc=new DOMDocument('1.0','UTF-8'); $doc->formatOutput=true;
  $root=$doc->appendChild($doc->createElement('Articole'));
  foreach($articole as $a){
    $lin=$root->appendChild($doc->createElement('Linie'));
    addEl($doc,$lin,'Cod',      arr_get($a,'cod'));
    addEl($doc,$lin,'Denumire', arr_get($a,'denumire'));
    addEl($doc,$lin,'UM',       arr_get($a,'um','buc'));
    addEl($doc,$lin,'Tip',      arr_get($a,'tip'));
    addEl($doc,$lin,'TVA',      normProcTva(arr_get($a,'tva'))); // 21, 19 etc.
    addEl($doc,$lin,'Pret',     arr_get($a,'pretVanz'));
    addEl($doc,$lin,'Pret_TVA', arr_get($a,'pretVTva'));
    addEl($doc,$lin,'Cod_bare', arr_get($a,'codBare'));
    addEl($doc,$lin,'Cod_NC',   arr_get($a,'codFe'));
    addEl($doc,$lin,'Cod_CPV',  arr_get($a,'codCpv'));
  }
  $doc->save($filePath);
}

/* ==== GROUP + EXPORT FACTURI (BULK) ==== */
function groupInvoicesByNumber(array $rows, string $tip): array {
  $by = [];
  foreach ($rows as $r){
    $nr = ($tip==='iesiri')
      ? arr_get_any($r, ['nrIesire', 'NR_IESIRE'])
      : arr_get_any($r, ['nrIntrare', 'NR_INTRARE', 'nrNir', 'NR_NIR']);
    if(!$nr) continue;
    if(!isset($by[$nr])){
      $by[$nr] = [
        'numar'    => $nr,
        'data'     => arr_get_any($r, ['data', 'DATA']),
        'scadent'  => arr_get_any($r, ['scadent', 'SCADENT']),
        'moneda'   => arr_get_any($r, ['moneda', 'MONEDA']),
        'tip'      => arr_get_any($r, ['tip', 'TIP']),
        'curs'     => arr_get_any($r, ['curs', 'CURS']),
        'gestiune' => arr_get_any($r, ['gestiune', 'GESTIUNE']),
        'cod'      => arr_get_any($r, ['cod', 'COD']), // cod tert
        'denumire' => arr_get_any($r, ['denumire', 'DENUMIRE']), // denumire tert
        'facturaInformatiiSuplimentare' => arr_get_any($r, ['facturaInfSupl', 'FACTURA_INF_SUPL']),
        'linii'    => []
      ];
    }
    $by[$nr]['linii'][] = [
      'descriere' => arr_get_any($r, ['denArt', 'DEN_ART'], 'Articol'),
      'codArt'    => arr_get_any($r, ['codArt', 'COD_ART']),
      'um'        => arr_get_any($r, ['um', 'UM'], 'buc'),
      'cantitate' => arr_get_any($r, ['cantitate', 'CANTITATE'], '1.000'),
      'pret'      => arr_get_any($r, ['pretVanz', 'PRET_VANZ'], arr_get_any($r, ['valoare', 'VALOARE'])),
      'valoare'   => arr_get_any($r, ['valoare', 'VALOARE']),
      'tva'       => arr_get_any($r, ['tva', 'TVA']),
      'procTva'   => normProcTva(arr_get_any($r, ['tvaArt', 'TVA_ART'])),
      'cont'      => arr_get_any($r, ['cont', 'CONT']),
      'gestiune'  => arr_get_any($r, ['gestiune', 'GESTIUNE']),
      //'pretVanzare' => ($tip==='intrari') ? arr_get($r,'pretVanz','') : '',
    ];
  }
  ksort($by, SORT_NATURAL);
  return array_values($by);
}

function indexByCod(array $rows): array {
  $m=[]; foreach($rows as $r){ if(isset($r['cod'])) $m[$r['cod']]=$r; } return $m;
}

function exportFacturiBulkXML(array $facturi, string $tip, array $company, array $mapTertiByCod, string $filePath){
  if (!$facturi) return null;
  $doc=new DOMDocument('1.0','UTF-8'); $doc->formatOutput=true;
  $root=$doc->appendChild($doc->createElement('Facturi'));

  foreach($facturi as $f){
    $fac=$root->appendChild($doc->createElement('Factura'));
    $ant=$fac->appendChild($doc->createElement('Antet'));

    if($tip==='iesiri'){
      $client = $mapTertiByCod[$f['cod']] ?? ['denumire'=>$f['denumire'],'codFiscal'=>''];
      addEl($doc,$ant,'FurnizorNume', $company['name']);
      addEl($doc,$ant,'FurnizorCIF',  $company['cif']);
      addEl($doc,$ant,'ClientNume',   arr_get($client,'denumire'));
      addEl($doc,$ant,'ClientCIF',    arr_get($client,'codFiscal',''));
    } else {
      $furn = $mapTertiByCod[$f['cod']] ?? ['denumire'=>$f['cod'],'codFiscal'=>''];
      addEl($doc,$ant,'FurnizorNume', arr_get($furn,'denumire'));
      addEl($doc,$ant,'FurnizorCIF',  arr_get($furn,'codFiscal',''));
      addEl($doc,$ant,'ClientNume',   $company['name']);
      addEl($doc,$ant,'ClientCIF',    $company['cif']);
      addEl($doc,$ant,'FacturaTip',    $f['tip']);
    }

    addEl($doc,$ant,'FacturaNumar', (string)$f['numar']);
    addEl($doc,$ant,'FacturaData', $f['data']);
    addEl($doc,$ant,'FacturaScadenta', $f['scadent']);
    addEl($doc,$ant,'FacturaInformatiiSuplimentare', arr_get($f,'facturaInformatiiSuplimentare',''));
    addEl($doc,$ant,'FacturaMoneda', $f['moneda']);
    addEl($doc,$ant,'Cod', $company['cod']);


    $det=$fac->appendChild($doc->createElement('Detalii'));
    $cnt=$det->appendChild($doc->createElement('Continut'));
    $i=0;
    foreach($f['linii'] as $r){
      $i++;
      $lin=$cnt->appendChild($doc->createElement('Linie'));
      addEl($doc,$lin,'LinieNrCrt',$i);
      if(arr_get($r,'gestiune')!=='') addEl($doc,$lin,'Gestiune',arr_get($r,'gestiune'));
      addEl($doc,$lin,'Descriere',arr_get($r,'descriere','Articol'));
      if($tip==='intrari') addEl($doc,$lin,'CodArticolFurnizor',arr_get($r,'codArt',''));
      else                 addEl($doc,$lin,'CodArticolClient',  arr_get($r,'codArt',''));
      addEl($doc,$lin,'UM',arr_get($r,'um','buc'));
      addEl($doc,$lin,'Cantitate',arr_get($r,'cantitate','1.000'));
      addEl($doc,$lin,'Pret',arr_get($r,'pret',arr_get($r,'valoare','')));
      addEl($doc,$lin,'Valoare',arr_get($r,'valoare',''));
      $proc = arr_get($r,'procTva','');
      if($proc!=='') addEl($doc,$lin,'ProcTVA',$proc);
      addEl($doc,$lin,'TVA',arr_get($r,'tva',''));
      addEl($doc,$lin,'Cont',arr_get($r,'cont',''));
      if($tip==='intrari' && arr_get($r,'pretVanzare','')!=='') addEl($doc,$lin,'PretVanzare',arr_get($r,'pretVanzare'));
    }
  }
  $doc->save($filePath);
  return $filePath;
}

// /* ==== MAIN: GENEREAZĂ FIȘIERELE, pe baza JSON-urilor DEJA DECODATE ==== */

// // director export
// $exportDir = __DIR__ . '/export_saga/';
// if (!is_dir($exportDir)) { @mkdir($exportDir, 0777, true); }

// echo $exportDir;

// // nomenclatoare (dacă există în răspuns)
// $exported = [];
// if (!empty($vendorJson['furnizori'])) {
//   $fpath = $exportDir . "/FUR_" . date('Y-m-d_His') . ".xml";
//   exportFurnizoriXML($vendorJson['furnizori'], $fpath);
//   $exported['furnizori'] = $fpath;
// }
// if (!empty($clientJson)) { // la tine clientJson e [] sau array de clienți
//   $cpath = $exportDir . "/CLI_" . date('Y-m-d_His') . ".xml";
//   exportClientiXML($clientJson, $cpath);
//   $exported['clienti'] = $cpath;
// }
// if (!empty($productsJson['articole'])) {
//   $apath = $exportDir . "/ART_" . date('Y-m-d_His') . ".xml";
//   exportArticoleXML($productsJson['articole'], $apath);
//   $exported['articole'] = $apath;
// }

// // facturi: folosește $requestJson conform tipului (4=iesiri, 5=intrari)
// if ($_GET["type"] == 4 && !empty($requestJson['iesiri'])) {
//   $facturi = groupInvoicesByNumber($requestJson['iesiri'], 'iesiri');
//   $fpath = $exportDir . "/F_IESIRI_" . date('Ymd_His') . ".xml";
//   exportFacturiBulkXML($facturi, 'iesiri', $COMPANY, indexByCod($clientJson ?? []), $fpath);
//   $exported['facturi_iesiri'] = $fpath;
// }
// if ($_GET["type"] == 5 && !empty($requestJson['intrari'])) {
//   $facturi = groupInvoicesByNumber($requestJson['intrari'], 'intrari');
//   $fpath = $exportDir . "/F_INTRARI_" . date('Ymd_His') . ".xml";
//   exportFacturiBulkXML($facturi, 'intrari', $COMPANY, indexByCod($vendorJson['furnizori'] ?? []), $fpath);
//   $exported['facturi_intrari'] = $fpath;
// }

// /* ==== include și căile fișierelor în răspunsul tău JSON existent ==== */
// $response['exported'] = $exported;



// === DOAR DOWNLOAD FACTURI, FĂRĂ SALVARE PE DISC ===
// NU pune niciun echo înainte de acest bloc!

$type = isset($_GET['type']) ? (int)$_GET['type'] : 0;
if ($type !== 4 && $type !== 5) {
    http_response_code(400);
    exit('Parametrul "type" trebuie să fie 4 (iesiri) sau 5 (intrari).');
}

$tip        = ($type === 4) ? 'iesiri' : 'intrari';
$prefixName = ($type === 4) ? 'F_IESIRI_' : 'F_INTRARI_';
$filename   = $prefixName . date('Y-m-d_His') . '.xml';

// 1) linii flat -> facturi
$rows = $requestJson[$tip] ?? [];
if (!$rows) {
    http_response_code(404);
    exit('Nu există linii de factură pentru tipul cerut.');
}
$facturi = groupInvoicesByNumber($rows, $tip);


//var_dump($rows);

// 2) map terți (clienți/furnizori) pentru antet
$mapTerti = ($type === 4)
    ? indexByCod($clientJson ?? [])
    : indexByCod($vendorJson['furnizori'] ?? []);

// 3) construiește XML în memorie (fără salvare pe disc)
//  - dacă ai deja o funcție similară, folosește-o; altfel, păstrează pe cea de mai jos:
if (!function_exists('buildFacturiXmlString')) {
    function buildFacturiXmlString(array $facturi, string $tip, array $company, array $mapTertiByCod): string {
        $doc = new DOMDocument('1.0','UTF-8'); $doc->formatOutput = true;
        $root = $doc->appendChild($doc->createElement('Facturi'));
        foreach ($facturi as $f) {

            $fac = $root->appendChild($doc->createElement('Factura'));
            $ant = $fac->appendChild($doc->createElement('Antet'));

            if ($tip === 'iesiri') {
                $client = $mapTertiByCod[$f['cod']] ?? ['denumire'=>$f['denumire'],'codFiscal'=>''];
                $ant->appendChild($doc->createElement('FurnizorNume', $company['name']));
                $ant->appendChild($doc->createElement('FurnizorCIF',  $company['cif']));
                $ant->appendChild($doc->createElement('ClientNume',   $client['denumire']));
                $ant->appendChild($doc->createElement('ClientCIF',    $client['codFiscal'] ?? ''));
            } else {
                $furn = $mapTertiByCod[$f['cod']] ?? ['denumire'=>$f['cod'],'codFiscal'=>''];
                $ant->appendChild($doc->createElement('FurnizorNume', $furn['denumire']));
                $ant->appendChild($doc->createElement('FurnizorCIF',  $furn['codFiscal'] ?? ''));
                $ant->appendChild($doc->createElement('ClientNume',   $company['name']));
                $ant->appendChild($doc->createElement('ClientCIF',    $company['cif']));
                $ant->appendChild($doc->createElement('FacturaTip',    $f['tip']));
                
            }

            $data = $f['data']; $scad = $f['scadent'];
            $ant->appendChild($doc->createElement('Cod',    $f['cod']));
            $ant->appendChild($doc->createElement('FacturaNumar', (string)$f['numar']));
            $ant->appendChild($doc->createElement('FacturaData',  $data));
            $ant->appendChild($doc->createElement('FacturaScadenta', $scad));
            if (!empty($f['facturaInformatiiSuplimentare'])) {
                $ant->appendChild($doc->createElement('FacturaInformatiiSuplimentare', $f['facturaInformatiiSuplimentare']));
            }
            if (!empty($f['moneda'])) $ant->appendChild($doc->createElement('FacturaMoneda', $f['moneda']));
            if (!empty($f['curs']))   $ant->appendChild($doc->createElement('FacturaCurs',   $f['curs']));

            $det = $fac->appendChild($doc->createElement('Detalii'));
            $cnt = $det->appendChild($doc->createElement('Continut'));
            $i=0;
            foreach ($f['linii'] as $r) {
                $i++;
                $lin = $cnt->appendChild($doc->createElement('Linie'));
                $lin->appendChild($doc->createElement('LinieNrCrt', $i));
                if (!empty($r['gestiune'])) $lin->appendChild($doc->createElement('Gestiune', $r['gestiune']));
                $lin->appendChild($doc->createElement('Descriere',  $r['descriere'] ?? 'Articol'));
                if ($tip==='intrari') $lin->appendChild($doc->createElement('CodArticolFurnizor', $r['codArt'] ?? ''));
                else                  $lin->appendChild($doc->createElement('CodArticolClient',   $r['codArt'] ?? ''));
                $lin->appendChild($doc->createElement('UM',         $r['um'] ?? 'buc'));
                $lin->appendChild($doc->createElement('Cantitate',  $r['cantitate'] ?? '1.000'));
                $lin->appendChild($doc->createElement('Pret',       $r['pret'] ?? ($r['valoare'] ?? '')));
                $lin->appendChild($doc->createElement('Valoare',    $r['valoare'] ?? ''));
                if (!empty($r['procTva'])) $lin->appendChild($doc->createElement('ProcTVA', $r['procTva']));
                $lin->appendChild($doc->createElement('TVA',        $r['tva'] ?? ''));
                if (!empty($r['cont']))    $lin->appendChild($doc->createElement('Cont', $r['cont']));
                if ($tip==='intrari' && !empty($r['pretVanzare'])) $lin->appendChild($doc->createElement('PretVanzare', $r['pretVanzare']));
            }
        }
        return $doc->saveXML();
    }
}

// 4) generează XML în memorie și livrează ca attachment
$xml = buildFacturiXmlString($facturi, $tip, $COMPANY, $mapTerti);

if (ob_get_level()) { ob_end_clean(); }
header('Content-Description: File Transfer');
header('Content-Type: application/xml; charset=UTF-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Length: ' . strlen($xml));
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

echo $xml;
exit;


?>
