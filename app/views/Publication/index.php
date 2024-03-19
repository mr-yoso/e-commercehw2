<html>
<head>
    <title><?= $name ?> view</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
</head>
<body>
    <div class='container'>
        <?php 
        echo "<h1>Hi</h1>";
        if (!empty($data['publications'])) {
            foreach ($data['publications'] as $publication) {
                echo "<h1>{$publication->publication_title}</h1><br><p>{$publication->publication_text} {$publication->timestamp}</p>";
            }
        } else {
            echo "<p>No publications found.</p>";
        }
        ?>

		<a href="/Publication/create"><button>Create Message</button></a>
		<a href="/Profile/modify"><button>Modify Account</button></a>
		<a href="/Publication/modify"><button>Modify My Messages</button></a>
    </div>
</body>
</html>
