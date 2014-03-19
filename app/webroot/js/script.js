/*----- SCRIPT -----*/

function validationUsername(username)
{
    var usernameValid = /^[A-Za-z0-9-_s]+$/;
    return usernameValid.test(username);
}
function validationEmail(email)
{
    var emailValid = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return emailValid.test(email);
}

function generalAlert(message)
{
    $("#generalAlert").fadeOut(0);
    $("#generalAlert").fadeIn(500);
    document.getElementById("generalAlert").innerHTML = '<p class="alert alert-danger">'+message+'</p>';
    $("#generalAlert").delay(5000).fadeOut(500);
}

function loginValidation()
{
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    if(username == "" || password == "")
    {
        generalAlert("Remplissez tous les champs.");
        return false;
    }
    if(username.length < 2 || password.length < 2)
    {
        generalAlert("Il faut un minimum de 2 caractères par champ.");
        return false;
    }
    if(!validationUsername(username))
    {
        generalAlert("Nom d'utilisateur invalide.");
        return false;
    }
    else 
    {
        document.loginForm.submit();
        return true;
    }
}

function signinValidation()
{
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var nom = document.getElementById("nom").value;
    var prenom = document.getElementById("prenom").value;
    var adresse = document.getElementById("adresse").value;
    var telephone = document.getElementById("telephone").value;
    var ville = document.signinForm.ville.value;

    if(username == "" || email == "" || password == "" || nom == "" || prenom == "" || adresse == "" || telephone == "") 
    {
        generalAlert("Remplissez tous les champs.");
        return false;
    }
    if(username.length < 2 || email.length < 2 || password.length < 2 || nom.length < 2 || prenom.length < 2 || adresse.length < 2) 
    {
        generalAlert("Il faut un minimum de 2 caractères par champ.");
        return false;
    }
    if(!validationUsername(username))
    {
        generalAlert("Nom d'utilisateur invalide.");
        return false;
    }
    if(!validationEmail(email))
    {
        generalAlert("Email invalide.");
        return false;
    }
    if(document.getElementById("username").style.color == "red")
    {
        generalAlert("Nom d'utilisateur indisponible.");
        return false;
    }
    if(document.getElementById("email").style.color == "red")
    {
        generalAlert("Email indisponible.");
        return false;
    }
    if(telephone.length < 10 && telephone.length > 10)
    {
        generalAlert("numéro de téléphone invalide.");
        return false;
    }
    if(ville == "0")
    {
        generalAlert("Vous devez choisir une ville.");
        return false;
    }
    else 
    {
        document.signinForm.submit();
        return true;
    }
}

function compteValidation()
{
    var email = document.getElementById("email").value;
    var nom = document.getElementById("userNom").value;
    var prenom = document.getElementById("userPrenom").value;
    var adresse = document.getElementById("userAdresse").value;
    var telephone = document.getElementById("userTelephone").value;
    var ville = document.compteForm.ville.value;

    if(email == "" || nom == "" || prenom == "" || adresse == "" || telephone == "") 
    {
        generalAlert("Remplissez tous les champs.");
        return false;
    }
    if(email.length < 2 || nom.length < 2 || prenom.length < 2 || adresse.length < 2)
    {
        generalAlert("Il faut un minimum de 2 caractères par champ.");
        return false;
    }
    if(!validationEmail(email))
    {
        generalAlert("Email invalide.");
        return false;
    }
    if(document.getElementById("email").style.color == "red")
    {
        generalAlert("Email indisponible.");
        return false;
    }
    if(telephone.length < 10 && telephone.length > 10)
    {
        generalAlert("numéro de téléphone invalide.");
        return false;
    }
    if(ville == "0")
    {
        generalAlert("Vous devez choisir une ville.");
        return false;
    }
    else 
    {
        document.compteForm.submit();
        return true;
    }
}

function confirmSupprimerCompte()
{
    if(confirm('Vous êtes sûr de vouloir supprimer le compte ?'))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function confirmModifierCompte()
{
    if(confirm('Vous êtes sûr de vouloir modifier les informations ?'))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/*----- AJAX -----*/

/*----------*/

function call(callback, element, call) 
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/ajax/"+call, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(element+"="+document.getElementById(element).value);
    xhr.onreadystatechange = function() 
    {
        if(xhr.readyState == 4)
        {
            callback(xhr.responseText);
        }
    };
}

/*---- FormArticleSousCategorie ----*/

function readSousCategories(data)
{
    document.getElementById("showSousCategorie").innerHTML = data;
}

/*---- FormSigninVilles ----*/

function readVilles(data)
{
    document.getElementById("showVilles").innerHTML = data;
}

/*---- FormSigninName ----*/

function readName(data)
{
    if(!document.getElementById("username").value == "" && document.getElementById("username").value.length > 2)
    {
        document.getElementById("usernameAlert").style.textAlign = "center";

        if(data == 'disponible')
        {
            document.getElementById("username").style.color = 'green';
        }
        else
        {
            document.getElementById("username").style.color = 'red';
        }

        if(!validationUsername(document.getElementById("username").value))
        {
            document.getElementById("usernameAlert").innerHTML = "Le nom d'utilisateur est invalide";
            document.getElementById("username").style.color = 'red';
        }
        else
        {
            document.getElementById("usernameAlert").innerHTML = "Le nom d'utilisateur est "+data;
        }
    }
    else
    {
        document.getElementById("usernameAlert").innerHTML = "";
        document.getElementById("username").style.color = 'black';
    }
}

/*---- FormSigninEmail ----*/

function readEmail(data)
{
    if(document.getElementById("email").value != "" && document.getElementById("email").value.length > 2)
    {
        if(data == 'disponible')
        {
            document.getElementById("email").style.color = 'green';
        }
        else
        {
            document.getElementById("email").style.color = 'red';
        }

        if(!validationEmail(document.getElementById("email").value))
        {
            document.getElementById("emailAlert").innerHTML = "L'email est invalide.";
            document.getElementById("email").style.color = 'red';
        }
        else
        {
            document.getElementById("emailAlert").innerHTML = "L'email est "+data+".";
            if(document.getElementById("email").value == document.getElementById("userEmail").value)
            {
                document.getElementById("emailAlert").innerHTML = "Vous utilisez déjà cette email.";
                document.getElementById("email").style.color = 'black';
            }
        }
    }
    else
    {
        document.getElementById("emailAlert").innerHTML = "";
        document.getElementById("email").style.color = 'black';
    }
}

function get_path() {
    if (document.location.pathname !== undefined) {
        return document.location.pathname.replace( /[<]/g, "&lt;").replace(/[>]/g, "&gt;");
    } else {
        return "&nbsp;";
    }
}