<!DOCTYPE html>
@php
define("DOMPDF_ENABLE_REMOTE", false);
@endphp
<html>
<head>
<style>
p, table {
  font-size: 16px;
}
</style>
    <title>Dichiarazione Centri per l'impiego</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="abcdx"> 
        
        <h6 align="center"><b>DICHIARAZIONE SOSTITUTIVA DELL'ATTO DI NOTORIETA'</b></h6>
        <h6 align="center"><b>(articolo 47 del D.P .R. n. 445 del 28 dicembre 2000)</b></h6><br>
        <h6 align="center"><b>Al FINI DELLA RICHIESTA NOMINATIVA DI NULLA OSTA AL LAVORO SUBORDINATO PER</b></h6>
        <h6 align="center"><b>L' INGRESSO IN ITALIA DI CITTADINO NON COMUNITARIO RESIDENTE ALL' ESTERO</b></h6>
        <h6 align="center"><b>(ai sensi dell' articolo 22 del Decreto Legislativo 25 lugli o 1998, n. 286 - TUI)</b></h6><br>

        <table>
            <tr>
                <td text-align="justify">Il   sottoscritto  DATORE DI LAVORO {{ $customer->firstname." ".$customer->lastname }}   nato   in   {{ $customer->pob }}  
                        @php
                        if($customer->dateofbirth == '0000-00-00')
                        {
                            $date1="00";
                            $month1="00";
                            $year1="0000";
                        }else{
                            $time=strtotime($customer->dateofbirth);
                            $date1=date("d",$time);
                            $month1=date("m",$time);
                            $year1=date("Y",$time);
                        }
                    @endphp
                    in  data   {{ $date1."/".$month1."/".$year1; }}   in
                    qualità di rappresentante legale della società/ditta @if(!empty($pdfdata['ragione_sociale'][0]->field_value)){{$pdfdata['ragione_sociale'][0]->field_value}}@endif
                    con codcie fiscale - @if(!empty($pdfdata['cf_azienda'][0]->field_value)){{$pdfdata['cf_azienda'][0]->field_value}}@endif,
                    codice partita iva - @if(!empty($pdfdata['flussi_partita_iva'][0]->field_value)){{$pdfdata['flussi_partita_iva'][0]->field_value}}@endif
                    e sede legale @if(!empty($pdfdata['indirizzo_sede'][0]->field_value)){{$pdfdata['indirizzo_sede'][0]->field_value}}@endif
                    in @if(!empty($pdfdata['citta_sede'][0]->field_value)){{$pdfdata['citta_sede'][0]->field_value}}@endif 
                    (@if(!empty($pdfdata['provincia_sede'][0]->field_value)){{$pdfdata['provincia_sede'][0]->field_value}}@endif) 
                    e CAP @if(!empty($pdfdata['cap_sede'][0]->field_value)){{$pdfdata['cap_sede'][0]->field_value}}@endif
                    scritto all'inps con matricola numero @if(!empty($pdfdata['matricola_inps'][0]->field_value)){{$pdfdata['matricola_inps'][0]->field_value}}@endif
                    e all'inail con codice ditta e alla camera di commercio di 
                    @if(!empty($pdfdata['sede_inail'][0]->field_value)){{$pdfdata['sede_inail'][0]->field_value}}@endif
                    al numero @if(!empty($pdfdata['numero_cciaa'][0]->field_value)){{$pdfdata['numero_cciaa'][0]->field_value}}@endif
                </td>
            </tr>
        </table>
        <br><br>
        <h6 align="center"><b>DICHIARA</b></h6>
        <br>
        <table>
            <tr>
                <td text-align="justify">di voler assumere dall'estero un cittadino non comunitario avendo verificato presso il centro per
                        l'impiego competente, l'indisponibilità di un lavoratore presente sul territorio nazionale a ricoprire il
                        posto di lavoro per il profilo richiesto, a tal fine
                </td>
            </tr>
        </table>

        <br><br>
        <h6 align="center"><b>CERTIFICA</b></h6>
        <h6 align="center"><b>(ai sensi dell'articolo 47 del D.P .R. n. 445 del 28 dicembre 2000)</b></h6>
        <br>
        <table>
            <tr>
                <td text-align="justify">- assenza di riscontro da parte del Centro per l'impiego circa l'individuazione di uno o più lavoratori
                        rispondenti alle caratteristiche richieste, decorsi quindici giorni lavorativi dalla richiesta di personale
                        effettuata dal sottoscritto;
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td text-align="justify">- accertamento da parte del sottoscritto di non idoneità del lavoratore, ad esito dell'attività di
                        selezione del personale inviato dal Centro per l' impiego;
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td text-align="justify">- mancata, non giustificata, presentazione al colloquio di selezione a seguito di convocazione da parte
                        del sottoscritto dei lavoratori inviati dal Centro per l'impiego, decorso un termine di almeno venti
                        giorni lavorativi dalla data della richiesta di personale effettuata dal sottoscritto al Centro per
                        l'impiego.
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td>Luogo e data {{ $customer->city }} ___/___/______</td>
                <td style="width:240px"> </td>
                <td align="right">Firma _________________</td>
            </tr>
        </table>
    </div>
</body>
</html>