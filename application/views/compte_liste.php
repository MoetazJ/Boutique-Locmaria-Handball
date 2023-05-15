<h1>Liste des comptes</h1>
<br />

<?php if($cpts != NULL): ?>
    <ul style="list-style: none; margin-top: 20px; margin-bottom: 20px;">
        <?php foreach($cpts as $cpt): ?>
            <li style="margin-bottom: 20px;">
                <h3>Compte ID : <?php echo $cpt['cpt_id']; ?></h3>
                <form method="post" action="<?php echo base_url('index.php/compte/modif_compte/'.$cpt['cpt_id']); ?>">
                    <div>
                        <label>Email : </label>
                        <input type="text" name="email" value="<?php echo $cpt['cpt_mail']; ?>"readonly>
                    </div>
                    <div>
                        <label>Nom : </label>
                        <input type="text" name="nom" value="<?php echo $cpt['pfl_nom']; ?>" readonly>
                    </div>
                    <div>
                        <label>ID du panier : </label>
                        <input type="text" name="panier" value="<?php echo $cpt['cart_id']; ?>" >
                    </div>
                    <div>
                        <label>Compte actif : </label>
                        <select name="actif">
                            <option value="A" <?php if ($cpt['compte_actif'] == 'A') echo 'selected'; ?>>Actif</option>
                            <option value="N" <?php if ($cpt['compte_actif'] == 'N') echo 'selected'; ?>>Non actif</option>
                        </select>
                    </div>
                    <div>
                        <label>Role : </label>
                        <select name="role">
                            <option value="A" <?php if ($cpt['pfl_role'] == 'A') echo 'selected'; ?>>Administrateur</option>
                            <option value="U" <?php if ($cpt['pfl_role'] == 'U') echo 'selected'; ?>>Utilisateur</option>
                        </select>
                    </div>
                    <button type="submit"  class="btn btn-modifier">Modifier</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun compte n'a été trouvé.</p>
<?php endif; ?>
<!--
<?php
   // echo validation_errors();
    //echo form_open('compte/ajout');
?>

<br>
<h4>Ajouter un compte</h4>
<br>
<div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" name="email" class="form-control" placeholder="Email" required>
</div>
<div class="form-group">
    <label for="exampleInputPassword1">Mot de passe</label>
    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
</div>
<div class="form-group">
    <label for="exampleInputPassword1">Confirmation du mot de passe</label>
    <input type="password" name="password_confirm" class="form-control" placeholder="Confirmation du mot de passe" required>
</div>
<div class="form-group">
    <label>Nom</label>
    <input type="text" name="nom" class="form-control" placeholder="Nom" required>
</div>
<div class="form-group">
    <label>Role</label>
    <select class="form-control" name="role">
        <
-->