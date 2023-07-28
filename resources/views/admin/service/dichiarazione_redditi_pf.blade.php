@if($files[0]->service == 'DICHIARAZIONE REDDITI PF')
            <div class="row">
                <label class="col-form-label">Sede Legale</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="indirizzo" class="col-form-label">Indirizzo</label>
                            
                            <input class="form-control" name="indirizzo" type="text" id="indirizzo" value="@if(!empty($pdfdata['indirizzo'][0]->field_value)){{$pdfdata['indirizzo'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="civico" class="col-form-label">Civico</label>
                            <input class="form-control" name="civico" type="text" id="civico" value="@if(!empty($pdfdata['civico'][0]->field_value)){{$pdfdata['civico'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="cap" class="col-form-label">CAP</label>
                            <input class="form-control" name="cap" type="text" id="cap" value="@if(!empty($pdfdata['cap'][0]->field_value)){{$pdfdata['cap'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="citta" class="col-form-label">Citta</label>
                            <input class="form-control" name="citta" type="text" id="citta" value="@if(!empty($pdfdata['citta'][0]->field_value)){{$pdfdata['citta'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="provincia" class="col-form-label">Provincia</label>
                            <input class="form-control" name="provincia" type="text" id="provincia" value="@if(!empty($pdfdata['provincia'][0]->field_value)){{$pdfdata['provincia'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label">Dati aizendali</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="partita_iva" class="col-form-label">Partita IVA</label>
                            <input class="form-control" name="partita_iva" type="text" id="partita_iva" value="@if(!empty($pdfdata['partita_iva'][0]->field_value)){{$pdfdata['partita_iva'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="codice_fiscale" class="col-form-label">Codice Fiscale</label>
                            <input class="form-control" name="codice_fiscale" type="text" id="codice_fiscale" value="@if(!empty($pdfdata['codice_fiscale'][0]->field_value)){{$pdfdata['codice_fiscale'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="codice_ateco" class="col-form-label">Codice Ateco</label>
                            <input class="form-control" name="codice_ateco" type="text" id="codice_ateco" value="@if(!empty($pdfdata['codice_ateco'][0]->field_value)){{$pdfdata['codice_ateco'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="tipo_attivita" class="col-form-label">Tipo Attivita</label>
                            <input class="form-control" name="tipo_attivita" type="text" id="tipo_attivita" value="@if(!empty($pdfdata['tipo_attivita'][0]->field_value)){{$pdfdata['tipo_attivita'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label">Auocertificazione di reddito da dichiarare</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="anno" class="col-form-label">ANNO</label>
                            
                            <input class="form-control" name="anno" type="text" id="anno" value="@if(!empty($pdfdata['anno'][0]->field_value)){{$pdfdata['anno'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="rif" class="col-form-label">RIF</label>
                            <input class="form-control" name="rif" type="text" id="rif" value="@if(!empty($pdfdata['rif'][0]->field_value)){{$pdfdata['rif'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="reddito" class="col-form-label">Reddito</label>
                            <input class="form-control" name="reddito" type="text" id="reddito" value="@if(!empty($pdfdata['reddito'][0]->field_value)){{$pdfdata['reddito'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label">Compilare solo per ditte individuali iscritti alla camera di commercio</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="registration_no" class="col-form-label">Numero iscrizione</label>
                            <input class="form-control" name="registration_no" type="text" id="registration_no" value="@if(!empty($pdfdata['registration_no'][0]->field_value)){{$pdfdata['registration_no'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="registration_date" class="col-form-label">Data iscrizione</label>
                            <input class="form-control" name="registration_date" type="date" id="registration_date" value="@if(!empty($pdfdata['registration_date'][0]->field_value)){{$pdfdata['registration_date'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="common_chamber_of_commerce" class="col-form-label">CCIAA di</label>
                            <input class="form-control" name="common_chamber_of_commerce" type="text" id="common_chamber_of_commerce" value="@if(!empty($pdfdata['common_chamber_of_commerce'][0]->field_value)){{$pdfdata['common_chamber_of_commerce'][0]->field_value}}@endif">
                        </div>
                    </div>
                </div>
            </div>
        @endif