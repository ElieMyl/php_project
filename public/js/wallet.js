document.addEventListener("DOMContentLoaded", function() {
    let modals = document.querySelectorAll(".modal");
    M.Modal.init(modals);

    document.querySelector(".depot").addEventListener("click", function() {
        M.Modal.getInstance(document.querySelector("#modalDepot")).open();
    });

    document.querySelector(".retrait").addEventListener("click", function() {
        M.Modal.getInstance(document.querySelector("#modalRetrait")).open();
    });

    document.getElementById("validerDepot").addEventListener("click", function() {

        let montant = document.getElementById("montantDepot").value;
        montant = parseFloat(montant);

        let solde = document.getElementById("solde-amount").textContent;
        solde = parseFloat(solde);

       let soldeActuel = solde + montant;

       if (montant > 10){
            
        
        $.ajax({

            url: '../public/ajaxWallet/depot.php',
            method: 'POST',
            data: 'solde_actuel=' + soldeActuel,
            success: function(data){

                if(data == 'ok'){

                    alert('Dépôt effectué avec succès');
                    location.reload();

                }
                else{

                    alert('Erreur lors du dépôt');

                }

            }

        })


       } else {
           alert('Le montant doit être supérieur à 10 €');
       }

    });



    document.getElementById("validerRetrait").addEventListener("click", function() {

        let montant = document.getElementById("montantRetrait").value;
        montant = parseFloat(montant);

        let solde = document.getElementById("solde-amount").textContent;
        solde = parseFloat(solde);

       if (montant > solde){
           alert('Solde insuffisant');
       } else {
            let soldeActuel = solde - montant;

            $.ajax({

                url: '../public/ajaxWallet/retrait.php',
                method: 'POST',
                data: 'solde_actuel=' + soldeActuel,
                success: function(data){
    
                    if(data == 'ok'){
    
                        alert('Retrait effectué avec succès');
                        location.reload();
    
                    }
                    else{
    
                        alert('Erreur lors du retrait');
    
                    }
    
                }
    
            })


       }
            

    });

});