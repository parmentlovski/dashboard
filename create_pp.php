<?php include('functions.php');
 include('header.php');
include('nav.php');

if (!isAdmin()):
    if ("GET" === $_SERVER["REQUEST_METHOD"]) {
      // Renvoie l'utilisateur à la racine du serveur
      header("Location: /");
      // Met fin au script par mesure de sécurité
      die();
    }
    endif ;?>

<title>Add pictures</title>
</head>
<body>

<div class="header">
		<h2>Create user</h2>
    </div>
    
    <section id='add-pp'>
	
	<form method="post" class="form-new form-notif" action="create_pp.php" enctype="multipart/form-data">
                <h2 class="text-center mt-1 mb-5">Ajouter une image</h2>

                <?php echo display_error(); ?>

                <div class="input-group input-group-icon">
                    <label>Nouvelle image :</label>
                    <input type="file" name="add_pp" accept="image/png, image/jpeg" />
                    <div class="input-icon input-icon-saison"><i class="fa fa-user"></i></div>
                </div>



                <button class="btn btn-success btn-valid mt-5 d-block ml-auto mr-auto mt-4" type="submit" name="add_pp_btn">
                    Faire une demande
                </button>

            </form>
    
	</section>

	<section id="list-profil-img" class="container">
            <div id="list-img" class="row">
                <?php echo list_profil_img(); ?>
            </div>
        </section>
	
<?php include('footer.php') ?>	

