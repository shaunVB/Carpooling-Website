<?php
    if(!isset($_SESSION)){session_start();}
?>
  <!-- Le styles -->
  <link href="css/lib/bootstrap.css" rel="stylesheet">
  <link href="css/lib/bootstrap-responsive.css" rel="stylesheet">
  <link href="css/lib/bootstrap-docs.css" rel="stylesheet">
  <link href="css/common/stylesheet.css" rel="stylesheet">
  <!-- Le javascript
  ================================================== -->
  <script src="js/lib/jquery.min.js"></script>
  <script src="js/lib/bootstrap.js"></script>

 

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<?php
  include_once 'navbar.php';
?>