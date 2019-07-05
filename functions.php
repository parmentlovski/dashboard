<?php
session_start();

// connect to database
$db = new PDO('mysql:host=localhost;dbname=multi_login', 'root', 'online@2017');

// variable declaration
$username = "";
$email    = "";
$season    = "";
$errors   = array();

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

if (isset($_POST['season_btn'])) {
	createSeason();
}

if (isset($_POST['notif_btn'])) {
	createNotif();
}

// REGISTER USER
function register()
{
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
	// defined below to escape form values
	$username    =  $_POST['username'];
	$email       =  $_POST['email'];
	$password_1  =  $_POST['password_1'];
	$password_2  =  $_POST['password_2'];
	$season = $_POST['season_user'];

	$sql_u = "SELECT * FROM users WHERE username=:username";
	$sth = $db->prepare($sql_u);
	$sth->bindParam(':username', $username, PDO::PARAM_STR);
	$sth->execute();
	$result_u = $sth->fetchAll(PDO::FETCH_ASSOC);

	$sql_e = "SELECT * FROM users WHERE email=:email";
	$sth = $db->prepare($sql_e);
	$sth->bindParam(':email', $email, PDO::PARAM_STR);
	$sth->execute();
	$result_e = $sth->fetchAll(PDO::FETCH_ASSOC);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	if (Count($result_u) > 0) {
		array_push($errors, "Sorry... username already taken");
	} else if (Count($result_e) > 0) {
		array_push($errors, "Sorry... email already taken");
	} else {
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1); //encrypt the password before saving in the database
			$user_type = $_POST['user_type'];
			$sql = "INSERT INTO users (username, email, user_type, password) 
					  VALUES(:username, :email, :user_type, :password)";
			$sth = $db->prepare($sql);
			$sth->bindParam(':username', $username, PDO::PARAM_STR);
			$sth->bindParam(':email', $email, PDO::PARAM_STR);
			$sth->bindParam(':user_type', $user_type, PDO::PARAM_STR);
			$sth->bindParam(':password', $password, PDO::PARAM_STR);
			$sth->execute();

			$last_id = $db->lastInsertId();


			$sql_s = "SELECT * FROM saison WHERE date_saison='$season'";
			$sth_s = $db->prepare($sql_s);
			$sth_s->bindParam(':date_saison', $season, PDO::PARAM_STR);
			$sth_s->execute();
			$result = $sth_s->fetchAll();
			$idSeason = $result[0]["id_saison"];
			echo $idSeason;
			echo $last_id;

			$sql = "INSERT INTO inscription (user_identifiant, saison_id) 
					  VALUES(:user_identifiant, :saison_id)";
			$sth = $db->prepare($sql);
			$sth->bindParam(':user_identifiant', $last_id, PDO::PARAM_INT);
			$sth->bindParam(':saison_id', $idSeason, PDO::PARAM_STR);
			$sth->execute();


			$_SESSION['success']  = "New user successfully created!!";
			header('Location: home.php');
		}
	}
}

// return user array from their id
// function getUserById($id)
// {
// 	global $db;
// 	$query = "SELECT * FROM users WHERE id=" . $id;
// 	$result = mysqli_query($db, $query);
// 	$user = mysqli_fetch_assoc($result);
// 	echo'ici';
// 	return $user;
// }

function createSeason()
{

	global $db, $errors, $season;
	$season =  $_POST['season'];

	if (empty($season)) {
		array_push($errors, "Une saisie est requise");
	}

	if (count($errors) == 0) {

		$sql = "INSERT INTO saison (date_saison) 
		VALUES('$season')";
		$sth = $db->prepare($sql);
		$sth->execute();
		$_SESSION['success']  = "New user successfully created!!";
		header('location: home.php');
	}
}

function createNotif()
{
	// ajout de la date de l'evenement
	global $db, $errors, $users;
	$dateEvent = $_POST['date_event'];
	$lieuMatch = $_POST['lieu_event'];
	$dispoEvent = $_POST['dispo_event'];
	$noReponse = NULL;

	if (empty($dateEvent)) {
		array_push($errors, "Date is required");
	}
	if (empty($lieuMatch)) {
		array_push($errors, "Place is required");
	}
	if (empty($dispoEvent)) {
		array_push($errors, "Dispo is required");
	}
	// $sql = "INSERT INTO saison (date_saison) 
	// VALUES('$season')";
	// $sth = $db->prepare($sql);
	// $sth->execute();

	// Requete insert mon formulaire dans la table planning
	$sql = "INSERT INTO planning (jour_event, lieu, places_necessaires) 
		VALUES(:jour_event, :lieu, :places_necessaires)";
	$sth = $db->prepare($sql);
	$sth->bindParam(':jour_event', $dateEvent, PDO::PARAM_STR);
	$sth->bindParam(':lieu', $lieuMatch, PDO::PARAM_STR);
	$sth->bindParam(':places_necessaires', $dispoEvent, PDO::PARAM_STR);
	$sth->execute();

	// je vais sortir mes date d'evenement de la table planning
	// $stmt = $db->prepare("SELECT * FROM planning");
	// if ($stmt->execute(array())) {
	// while ($row = $stmt->fetch()) {
	// echo $row[0]. '<br>';
	// }
	// }

	$sql_u = "SELECT id FROM users";
	$sth_u = $db->prepare($sql_u);
	$sth_u->execute();
	$result = $sth_u->fetchAll(PDO::FETCH_ASSOC);

	// output data of each row
	foreach ( $result as $users => $sql_u) {
		$sql_b = "INSERT INTO response_parent (jour_event, id_user, reponse) VALUES(:jour_event, :id_user, :reponse)";
		$sth = $db->prepare($sql_b);
		$sth->bindParam(':jour_event', $dateEvent, PDO::PARAM_STR);
		$sth->bindParam(':id_user', $sql_u["id"], PDO::PARAM_INT);
		$sth->bindParam(':reponse', $noReponse, PDO::PARAM_STR);
		$sth->execute();
	}
}

function display_error()
{
	global $errors;

	if (count($errors) > 0) {
		echo '<div class="error">';
		foreach ($errors as $error) {
			echo $error . '<br>';
		}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login()
{
	global $db, $username, $errors;

	// grap form values
	$username = $_POST['username'];
	$password = $_POST['password'];

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute();
		$results = $db->query($sql);

		// $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		// $result = $db->query($query);

		if ($results->rowCount() == 1) { // user found
			// check if user is admin or user
			$logged_in_user = $results->fetch(PDO::FETCH_ASSOC);

			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');
			} else {
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
			}
		} else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin') {
		return true;
	} else {
		return false;
	}
}
