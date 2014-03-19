<div class="breadcrumbs">
    <ul>
        <li><a href="/../accueil">Accueil</a></li>
        <li>Connexion</li>
    </ul>
</div>
<div class="inscription offset5 span5 shadow">
    <form class="form-login-signin" method="post" onsubmit="return loginValidation();">
    	<h2 class="form-login-signin-heading">Connexion</h2>
        <div class="input-control text size4">
        	<input type="text" id="username" class="form-control" name="username" placeholder="Nom d'utilisateur" autofocus>
        	<input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe">
        	<button class="primary valid-btn" type="submit">Connexion</button>
            <div class="input-control lien-box">
                <a href="/user/signin">Pas encore membre ?</a>
            </div>
        </div>
    </form>
</div>