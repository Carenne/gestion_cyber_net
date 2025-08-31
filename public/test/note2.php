 <script>
                //Mini
                  function loadTotalMini() {
                      $.post("vendeur/paiement/total_paiement.php", { pointVente: "Mini-croc" }, function (res) {
                          let total = res.total || 0;
                          $('#TotalMn').html(totalPaiement.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
                  function loadTotalMiniPure() {
                      $.post("vendeur/paiement/total_paiement_pure.php", { pointVente: "Mini-croc" }, function (res) {
                          let total = res.total || 0;
                          $('#Total_pureMn').html(totalPaiement.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }

                  function loadBonus() {
                      $.post("bonus/bonus_data.php", { pointVente: "Mini-croc" }, function(res) {
                          let total = res.totalBonus || 0;
                           $('#Total_bonusMn').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
                  //tok
                    //Mini
                  function loadTotalTok() {
                      $.post("vendeur/paiement/total_paiement.php", { pointVente: "Tok" }, function (res) {
                          let total = res.total || 0;
                          $('#TotalTok').html(totalPaiement.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
                  function loadTotalTokPure() {
                      $.post("vendeur/paiement/total_paiement_pure.php", { pointVente: "Tok" }, function (res) {
                          let total = res.total || 0;
                          $('#Total_pureTok').html(totalPaiement.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }

                  function loadBonusTok() {
                      $.post("bonus/bonus_data.php", { pointVente: "Tok" }, function(res) {
                          let total = res.totalBonus || 0;
                           $('#Total_bonusTok').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
           
                  //Fin Tok
               
                  // Au chargement de la page et toutes les 2 secondes
                  window.onload = function() {
                      loadTotalMini();
                      loadTotalMiniPure();
                      loadBonus();
                      loadTotalTok();
                      loadTotalTokPure();
                      loadBonusTok();

                    //  setInterval(calculTok, 2000);
                    //  setInterval(calculMini, 2000);
                  };
       