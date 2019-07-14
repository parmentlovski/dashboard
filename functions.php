<?php
session_start();

// connect to database
$db = new PDO('mysql:host=localhost;dbname=multi_login', 'root', 'online@2017');

// variable declaration
$username = "";
$email    = "";
$season    = "";
$errors   = array();
$validations = array();

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

if (isset($_POST['reponse_btn'])) {
	reponse();
}

if (isset($_POST['login_btn'])) {
	login();
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

$sqlUp = "UPDATE users SET username=test3 WHERE id=4";
$sthUp = $db->prepare($sqlUp);
$sthUp->bindParam(':username', $username, PDO::PARAM_STR);
$sthUp->execute();

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
		VALUES(:season)";
		$sth = $db->prepare($sql);
		$sth->bindParam(':season', $season, PDO::PARAM_STR);
		$sth->execute();
		$_SESSION['success']  = "New season successfully created!!";
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

	// Requete insert mon formulaire dans la table planning
	$sql = "INSERT INTO planning (jour_event, lieu, places_necessaires) 
		VALUES(:jour_event, :lieu, :places_necessaires)";
	$sth = $db->prepare($sql);
	$sth->bindParam(':jour_event', $dateEvent, PDO::PARAM_STR);
	$sth->bindParam(':lieu', $lieuMatch, PDO::PARAM_STR);
	$sth->bindParam(':places_necessaires', $dispoEvent, PDO::PARAM_STR);
	$sth->execute();

	$sql_b = "INSERT INTO response_parent (jour_event, id_user) VALUES(:jour_event, :id_user)";
	$sth = $db->prepare($sql_b);
	$sth->bindParam(':jour_event', $_POST["date_event"], PDO::PARAM_STR);
	$sth->bindParam(':id_user', $_SESSION['id'], PDO::PARAM_INT);
	$sth->execute();
	var_dump($_POST["date_event"]);
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

function display_validation()
{
	global $validations;

	if (count($validations) > 0) {
		echo '<div class="success">';
		foreach ($validations as $validation) {
			echo $validation . '<br>';
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
// $results = $db->query($sql);

// $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
// $result = $db->query($query);

if ($sth->rowCount() == 1) { // user found
// check if user is admin or user
$logged_in_user = $sth->fetch(PDO::FETCH_ASSOC);

if ($logged_in_user['user_type'] == 'admin') {

$_SESSION['user'] = $logged_in_user;
$_SESSION['success'] = "You are now logged in";
header('location: admin/home.php');
} else {
$_SESSION['user'] = $logged_in_user;
$_SESSION['success'] = "You are now logged in";

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

function reponse()
{
	global $db, $errors, $validations, $placesDispo;

	$name = $_SESSION['user']['id'];
	// var_dump($name);
	$dateE = $_POST['jour_event'];
	// var_dump($dateE);
	$placeReservees = $_POST['places_reservees'];
	// var_dump($placeReservees);


	if (isset($_POST['reponseOui']) && isset($_POST['reponseNon'])) {
		array_push($errors, "One answer is required");
	}

	if (count($errors) == 0) {

		if (!empty($_POST['reponseOui'])) {
			if (empty($dateE)) {
				array_push($errors, "Date is required");
			}
			if (empty($placeReservees)) {
				array_push($errors, "Number is required");
			}

			$sqlOui = "INSERT INTO response_parent (jour_event, id_user, reponse, places_reservees) VALUES('$dateE', '$name', true, '$placeReservees')";
			$sthOui = $db->prepare($sqlOui);
			$sthOui->bindParam(':jour_event', $dateE, PDO::PARAM_STR);
			$sthOui->bindParam(':id_user', $name, PDO::PARAM_STR);
			$sthOui->bindValue(':reponse', true, PDO::PARAM_BOOL);
			$sthOui->bindParam(':places_reservees', $placeReservees, PDO::PARAM_INT);
			$sthOui->execute();

			$sqlRp = "SELECT places_reservees FROM response_parent";
			$sthRp = $db->prepare($sqlRp);
			$sthRp->execute();
			$placesReservees = $sthRp->fetchAll(PDO::FETCH_ASSOC);
			$placesReserveesArray = $placesReservees[0]['places_reservees'];
			// echo($placesReserveesArray);

			$sql = "SELECT places_necessaires FROM planning WHERE jour_event='$dateE' ";
			$sth = $db->prepare($sql);
			$sth->execute();
			$placesNecessaires = $sth->fetchAll(PDO::FETCH_ASSOC);
			$placesNecessairesArray = $placesNecessaires[0]['places_necessaires'];
			echo($placesNecessairesArray);

			$sqlC = "SELECT SUM(places_reservees) as total FROM response_parent WHERE jour_event='$dateE'";
			$sthC = $db->prepare($sqlC);
			$sthC->execute();
			$countPlaces = $sthC->fetchAll(PDO::FETCH_ASSOC);
			// echo($countPlaces);
			$countArray = $countPlaces[0]["total"];
			// echo($countArray);

			if ($countArray > $placesNecessairesArray) {
				array_push($errors, "Le nombre de places nécessaires est atteinte");
			}
			if ($countArray < $placesNecessairesArray) {
				$placesDispo = $placesNecessairesArray - $countArray;
				array_push($validations, "Il reste " . $placesDispo . " places");
			}
		} else if (!empty($_POST['reponseNon'])) {
			$placesNon = 0;

			$sqlNon = "INSERT INTO response_parent (jour_event, id_user, reponse, places_reservees) VALUES('$dateE', '$name', false, '$placesNon')";
			$sthNon = $db->prepare($sqlNon);
			$sthNon->bindParam(':jour_event', $dateE, PDO::PARAM_STR);
			$sthNon->bindParam(':id_user', $name, PDO::PARAM_STR);
			$sthNon->bindValue(':reponse', false, PDO::PARAM_BOOL);
			$sthNon->bindParam(':places_reservees', $placesNon, PDO::PARAM_INT);
			$sthNon->execute();

			if (empty($dateE)) {
				array_push($errors, "Date is required");
			}
		}
	}
	// $placesReservees = $_POST['places_reservees'];
}

function showNotif()
{
	global $db, $dateEvent, $lieuMatch, $dispoEvent ;

	$sql = "SELECT * FROM planning ";
	$sth = $db->prepare($sql);
	$sth->bindParam(':jour_event', $dateEvent, PDO::PARAM_STR);
	$sth->bindParam(':lieu', $lieuMatch, PDO::PARAM_STR);
	$sth->bindParam(':places_necessaires', $dispoEvent, PDO::PARAM_STR);
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			
	foreach ($result as $row) { ?>
		<ul>
			<li><?php echo $row['jour_event']; ?></li>
			<li><?php echo $row['lieu']; ?></li>
			<li><?php echo $row['places_necessaires']; ?></li>
		</ul>			
	<?php
	}
}
?>
