<?php
    if (!file_exists('config.php')){
        header("Location: ../index.php");
    }
?>

<?php include('config.php') ?>
<?php include('includes/head_section.php'); ?>
<title>Platanony</title>
</head>

<body class="bg-dark">
	<!-- Container sous bootstrap prend toute la largeur -->
	<div class="container-fluid" style="padding:0;">

		<!-- navbar -->
		<?php require_once(ROOT_PATH . '/includes/navbar.php') ?>
		<!-- // navbar -->

		<!-- banner -->
		<?php //require_once(ROOT_PATH . '/includes/banner.php') ?>
		<!-- // banner -->

		<!-- Page content -->
		<div class="content">

            <?php require_once(ROOT_PATH .'/routes/router.php'); ?>

		</div>
		<!-- // Page content -->


        <script>

            var name = <?php
                    if (isset($_SESSION['admin_name'])){
                        echo json_encode($_SESSION['admin_name']);
                    }
                    else if (isset($_SESSION['team_name'])){
                        echo json_encode($_SESSION['team_name']);
                    }
                    else{
                        echo json_encode(null);
                    }
            ?>;
            var type = <?php
                    if (isset($_SESSION['admin_name'])){
                        echo json_encode('admin');
                    }
                    else{
                        echo json_encode('team');
                    }
            ?>;
            dynamic_nav(name, type);

        </script>


		<!-- footer -->
		<?php require_once(ROOT_PATH . '/includes/footer.php') ?>
		<!-- // footer -->
