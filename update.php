<?php include('functions.php');
include('header.php');

$userId = $_SESSION['user']['id'];

$sql_value = "SELECT * FROM users WHERE id='$userId'";
$sth_value = $db->prepare($sql_value);
$sth_value->execute();
$result_value = $sth_value->fetchAll(PDO::FETCH_ASSOC);

$ppId = $result_value[0]["profil_img"];

$sql_pp = "SELECT url_img FROM users WHERE id='$ppId'";
$sth_pp = $db->prepare($sql_pp);
$sth_pp->execute();
$result_pp = $sth_pp->fetch(PDO::FETCH_ASSOC);

$ppUrl = $result_pp[0]["url_img"];


?>
<?php include('nav_user.php') ?>

<main>

	<section id="update-user">

		<h3 class="text-center mt-5 mb-5">MON PROFIL</h3>
		<div id="container-pp" class="row">
			<img class="col-2 offset-5 bg-dark rounded-circle z-depth-0 p-4" src="<?php echo ($result_pp["url_img"]); ?>" class="w100" alt="">
		</div>
		<button type='button' id="btn-change-pp" name="btn-change-pp" class="btn btn-success btn-valid d-block ml-auto mr-auto m-4">Modifier ma photo de profil</button>
		<div id="container-modif">

			<form method="post" action="" class="form-new">

				<div class="input-group align-items-center">
					<label class=" mb-0 mr-2">Username : </label>
					<input id="input-username" type="text" name="usernameUp" disabled value="<?php echo $result_value[0]["username"] ?>">
					<span id="modif-username" class="badge badge-danger mb-0 ml-2">Modifier</span>
				</div>
				<div class="input-group align-items-center">
					<label class=" mb-0  mr-2">Email : </label>
					<input id="input-email" type="email" name="emailUp" disabled value="<?php echo $result_value[0]["email"] ?>">
					<span id="modif-email" class="badge badge-danger mb-0 ml-2">Modifier</span>
				</div>

				<div id="change-mdp">Changer de mot de passe</div>
				<div id="container-new-mdp">
					<div class="input-group align-items-center">
						<label class="mb-0 mr-2">Nouveaux mot de passe : </label>
						<input id="passwordUp" type="password" name="passwordUp">
					</div>

					<div class="input-group align-items-center">
						<label class="mb-0 mr-2">Repeter le nouveau mot de passe : </label>
						<input id="passwordUp_2" type="password" name="passwordUp_2">
					</div>
				</div>
				<div class="input-group align-items-center mb-4 mt-4">
					<label class="mb-0 mr-2">Mot de passe actuel : </label>
					<input id="password-verif" type="password" name="passwordVerif">
					<span class="info_comp">Veuillez renseigner votre mot de passe actuel pour valider les modifications</span>
				</div>
				<div class="input-group">
					<button id="btn-update" type="submit" class="btn btn btn-success btn-valid mt-5 d-block ml-auto mr-auto mt-4" disabled name="update_btn">Update settings</button>
				</div>
		</div>
		<?php echo display_error(); ?>
		</form>

</main>
<div id="pop-change-pp">
	<div id="btn-pop-close"></div>
	<div id="container-pp-pop" class="row mb-5">
		<img id="pp-view" class="col-2 offset-5 bg-white rounded-circle z-depth-0 p-4" src="<?php echo ($result_pp["url_img"]); ?>" class="w100" alt="">
	</div>
	<form action="update.php" method="post" class="form-change-pp">

		<div class="row w-100">
			<?php list_profil_img_update(); ?>
		</div>
		<button class="btn btn-success btn-valid mt-5 d-block ml-auto mr-auto mt-4" type="submit" name="valid-change-pp">
			Valider
		</button>
	</form>

</div>
</section>

<?php include('footer.php'); ?>