<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $name ?> view
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <header>
            <a href="/Publication/index">
                <h1>Totally not fake website</h1>
            </a>
            <nav>
                <a href="/User/login"><button>Login</button></a>
                <a href="/User/logout"><button>Logout</button></a>
                <a href="/User/register"><button>Signup</button></a>
                <a href="/Profile/index"><button>My Profile</button></a>
            </nav>
        </header>

        <h1>Do you want to delete this publication?</h1>
        <form action="/Publication/delete/<?= $publication_id ?>" method="post">
            <input type="hidden" name="publication_id" value="<?= $publication_id ?>">
            <button type="submit">Yes</button>
            <a href="/Publication/index"><button>No, go back</button></a>
        </form>
    </div>
</body>

</html>