<!DOCTYPE html>

<html>
<head>
<style>
div {
  margin-top: 20px;
  margin-bottom: 20px;
  margin-right: 10px;
  margin-left: 10px;
}
p, table {
  font-size: 14px;
}
</style>
    <title>Delega INPS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div>
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
        <p>All' INPS</p>
        <table>
            <tr>
                <td>Il sottoscritto {{$customer->lastname }} {{$customer->firstname}} , codice fiscale {{ $customer->taxid }}, nato a
                {{ $customer->pob }} provincia {{ $customer->citizenship }} il {{ $date1."/".$month1."/".$year1; }}
                </td>
            </tr>
        </table>
        <br>
        <p><b>DELEGA</b></p>
        <br>
        <p>
            L’Associazione UNICOLF - UNIONE ITALIANA COLF CF 97760450581, rappresentata per la sede territoriale di
            SPORTELLO UNICOLF - ROMA TUSCOLANO dal responsabile CHAKRABORTY POPY CF
            CHKPPY92A42Z249O
        </p>
        <br>
        <p><b>alla gestione di tutti i rapporti di lavoro domestico in qualità di datore di lavoro.</b></p>
        <table>
            <tr>
                <td style="width:15px;"></td>
                <td style="width:20px;" valign="top">1. </td>
                <td>Il sottoscritto si impegna a comunicare qualsiasi variazione dovesse intervenire in ordine alla delega;</td>
            </tr>
            <tr>
                <td style="width:15px;"></td>
                <td style="width:20px;" valign="top">2. </td>
                <td>ogni variazione della delega dovrà essere portata a conoscenza dell’INPS mediante l’apposita funzionalità
                    presente nella procedura informatica di gestione delle deleghe disponibile fra i servizi per il lavoro
                    domestico.In caso contrario la revoca non potrà avere effetto nei confronti dell’INPS prima che siano trascorsi
                    30 giorni dalla notifica della stessa;</td>
            </tr>
            <tr>
                <td style="width:15px;"></td>
                <td style="width:20px;" valign="top">3. </td>
                <td>il delegante assume, nei confronti dell’INPS e dei terzi, ogni responsabilità derivante dall’invio di
                    comunicazioni ed informazioni per suo conto da parte del delegato; in particolare il delegante assume ogni
                    responsabilità legata alla veridicità delle informazioni comunicate, alla correttezza ed alla rispondenza alla
                    normativa applicata.</td>
            </tr>
        </table>
        <br>
        <p>
        Il delegato si impegnerà a custodire presso di sé la delega –unitamente alla fotocopia di un valido documento di identità
        del delegante – per tutto il periodo di vigenza della stessa, nonché nei cinque anni successivi, e ad esibirla a richiesta
        </p>
        <br>
        <table>
            <tr>
                <td style="width:50%;">------------------</td>
                <td style="width:450px;"></td>
                <td style="width:50%;">-------------------</td>
            </tr>
            <tr>
                <td style="width:50%;">Luogo e data</td>
                <td style="width:450px"></td>
                <td style="width:50%;">Firma leggibile</td>
            </tr>
        </table>
        <br>
        <p><b>
        Ai sensi dell’art. 38 del D.P.R. 445/2000 e successive modifiche e integrazioni deve essere allegata una copia
        fotostatica non autenticata di un documento di identità del sottoscrittore
        </b></p>
        <br>
        <p><b>
        Informativa sul trattamento dei dati personali (Art. 13 del d.lgs. 30 giugno 2003, n. 196, recante “Codice in
        materia di protezione dei dati personali” e successive modifiche e integrazioni)
        </b><br>
        L’ INPS con sede in Roma, via Ciro il Grande, 21, in qualità di Titolare del trattamento, la informa che i dati personali
        raccolti attraverso la compilazione del presente modello, saranno trattati in osservanza dei presupposti e dei limiti
        stabiliti dal d.lgs.30 giugno 2003, n. 196 e smi, nonché dalla legge e dai regolamenti in materia, e utilizzati nello
        svolgimento delle attività per cui lei rilascia la delega. La informa, inoltre, che è nelle sue facoltà esercitare i diritti
        previsti dall’articolo 7 del citato decreto legislativo, rivolgendosi direttamente al Direttore provinciale INPS
        territorialmente competente
        </p>
    </div>
</body>
</html>