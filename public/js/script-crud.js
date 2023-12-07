$(function(){

    let fullUrl = window.location.href;
    let splitUrl = fullUrl.split("/");
    let urlApp = splitUrl[0]+"//"+splitUrl[2]+"/";

    function formatMillier(nombre)
    {
        return nombre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    $(document).on("click", "#suppressionHistoriquePortefeuille", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/portefeuille/ajax-historique-portefeuille/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                $("#labelhistoriquePortefeuille").text(formatMillier(data['montant']));
                $("#historique_portefeuilles_id").val(data['id']);
            }
        });
    });

    $(document).on("click", "#validationPortefeuille", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/portefeuille/ajax-validation-portefeuille/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                $("#labelportefeuille").text(formatMillier(data['montant']));
                $("#labelnomutilisateurs").text(data['nom']);
                $("#portefeuilles_id").val(data['id']);
            }
        });
    });

    $(document).on("click", "#suppression_places_id", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/place/ajax-suppression-place/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                let numero = "numéro ";
                $("#label_suppression_places").text(numero.concat(data['numero']));
                $("#places_id").val(data['id']);
            }
        });
    });

    $(document).on("click", "#suppression_voitures", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/voiture/ajax-suppression/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                $("#label_voitures").text(data['matricule']);
                $("#voitures_id").val(data['id']);
            }
        });
    });

    $(document).on("click", "#suppression_tarifParkings", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/tarifs/ajax-suppression/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                $("#labeltarifParkings").text(data['tarif']);
                $("#tarifParkings_id").val(data['id']);
            }
        });
    });

    $(document).on("click", "#ajout_voitures", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $("#places_id").val(id);
    });

    $(document).on("click", "#enlever_voitures", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/stationnements/ajax-envele-voitures/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                $("#label_enleve_voitures").text(data['matricule']);
                $("#voiture_id").val(data['id']);
            }
        });
    });

    $(document).on("click", "#enlever_voitures_admin", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/stationnements/ajax-envele-voitures/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                $("#label_enleve_voitures_admin").text(data['matricule']);
                $("#voitures_id").val(data['id']);
            }
        });
    });

    $(document).on("click", "#utilisateurs_etat", function(e){
        e.preventDefault();
        let id = $(this).attr("value");
        $.ajax({
            url: urlApp+"auth/utilisateurs/ajax-utilisateur/"+id,
            type: "get",
            dataType: "json",
            success: function(data)
            {
                let etat = "désactivé";
                if(data['etat'] == 0)
                {
                    etat = "activé"
                }
                $("#labelutilisateurs").text(etat);
                $("#labelnomutilisateurs").text(data['nom'])
                $("#utilisateurs_id").val(data['id']);
            }
        });
    });

    $(document).on("change", "#type_parametre", function(e){
        e.preventDefault();
        if($("#type_parametre").val() == "Avance")
        {
            $("#date_parametre").prop("disabled", false);
            $("#heure_parametre").prop("disabled", false);
        }
        else
        {
            $("#date_parametre").prop("disabled", true);
            $("#heure_parametre").prop("disabled", true);
        }
    });

    function getStructureHtmlButton(lien)
    {
        let html = `<button type="submit" class="btn btn-success text-white"> Valider</button>
                    <a href="${lien}" class="btn btn-danger text-white"> Annuler</a>`;
        return html;
    }

    $(document).on("click", "#button_modification", function(e){
        e.preventDefault();
        $("#type_parametre").prop("disabled", false);
        let lien = urlApp+"auth/parametres";
        let html = getStructureHtmlButton(lien);
        $("#button_validation_modification").empty();
        $("#button_validation_modification").append(html);
        if($("#type_parametre").val() == "Avance")
        {
            $("#date_parametre").prop("disabled", false);
            $("#heure_parametre").prop("disabled", false);
        }
    });

    $(document).on("click", "#button_modification_profile", function(e){
        e.preventDefault();
        let lien = urlApp+"auth/parametres/profile";
        let html = getStructureHtmlButton(lien);
        $("#button_profile").empty();
        $("#button_profile").append(html);
        $("#nom").prop("disabled", false);
        $("#prenom").prop("disabled", false);
    });

    $(document).on("click", "#button_modification_amende", function(e){
        e.preventDefault();
        let lien = urlApp+"auth/parametres";
        let html = getStructureHtmlButton(lien);
        $("#button_validation_modification_amende").empty();
        $("#button_validation_modification_amende").append(html);
        $("#tranche").prop("disabled", false);
        $("#montant").prop("disabled", false);
    });
});