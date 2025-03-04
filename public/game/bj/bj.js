document.getElementById("mise").addEventListener("click", function() {
    
    let mise = document.getElementById("betAmount").value;
    mise = parseFloat(mise);

    let solde = document.getElementById("solde-amount").textContent;
    solde = parseFloat(solde);

    if (mise > solde){
        alert('Solde insuffisant');
    } else {

        $.ajax({

            url: 'ajaxGame.php',
            method: 'POST',
            data: 'mise=' + mise,
            success: function(data){

                if(data == 'Gagné'){

                    alert('Mise effectué avec succès ✅');
                    alert('💸 Vous avez gagné : ' + mise + '€ 💸');
                    location.reload();

                }
                else if(data == 'Perdu'){
                    alert('Mise effectué avec succès ✅');
                    alert('❌ Vous avez perdu : ' + mise + '€  ❌');
                    location.reload();

                }
                else if(data == 'Égalité'){
                    alert('Mise effectué avec succès ✅');
                    alert('🟰 Égalité, vous avez récupéré votre mise : ' + mise + '€ 🟰');
                    location.reload();

                } else {
                    alert(data);
                }

            }

        })
    }
});