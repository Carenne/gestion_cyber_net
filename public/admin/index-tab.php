

<div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-10">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="Total_pureMn">150000 Ar (Pure)</h3>
                          <p class="text-success ms-2 mb-0 font-weight-medium">Mini-croc</p>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal" id="TotalMn">160000 Ar (Total)</h6>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="Total_bonusMn">10000 Ar</h3>
                          <p class="text-danger ms-2 mb-0 font-weight-medium">Mini-croc</p>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Bonus</h6>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-10">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="Total_pureTok">60000 Ar (Pure)</h3>
                          <p class="text-success ms-2 mb-0 font-weight-medium">Tok</p>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal" id="TotalTok">80000 Ar (Total)</h6>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="Total_bonusTok">20000 Ar</h3>
                          <p class="text-success ms-2 mb-0 font-weight-medium">Tok</p>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Bonus</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                       <?php include 'paiement-encours/paiement_encours_mini.php'; ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                       <?php include 'paiement-encours/paiement_encours_tok.php'; ?>
                  </div>
                </div>
              </div>
            </div>

               <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                      <div class="d-flex">
                        <button class="btn btn-primary flex-fill m-1" onclick="sendRing('Mini-croc','ring1.mp3')">Paiement non Eregistrer</button>
                        <button class="btn btn-success flex-fill m-1" onclick="sendRing('Mini-croc','ring2.mp3')">Paiement non Valider</button>
                        <button class="btn btn-warning flex-fill m-1" onclick="sendRing('Mini-croc','ring3.mp3')">Verifier la reclamation</button>
                        <button class="btn btn-danger flex-fill m-1" onclick="sendRing('Mini-croc','ring4.mp3')">un paiement a distance</button>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                      <div class="d-flex">
                        <button class="btn btn-primary flex-fill m-1" onclick="sendRing('Tok','ring1.mp3')">Paiement non Eregistrer</button>
                        <button class="btn btn-success flex-fill m-1" onclick="sendRing('Tok','ring2.mp3')">Paiement non Valider</button>
                        <button class="btn btn-warning flex-fill m-1" onclick="sendRing('Tok','ring3.mp3')">Verifier la reclamation</button>
                        <button class="btn btn-danger flex-fill m-1" onclick="sendRing('Tok','ring4.mp3')">un paiement a distance</button>
                      </div>
                  </div>
                </div>
              </div>
            </div>