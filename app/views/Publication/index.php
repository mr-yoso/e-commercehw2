<html>

<head>
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
    <div class='container'>
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

        <a href="/Publication/create"><button>Create Message</button></a>

        <?php foreach ($publications as $publication): ?>
            <div class="mb-3">
                <h3>
                    <?= $publication->publication_title; ?>
                </h3>
                <p>
                    <?= $publication->publication_text; ?>
                </p>
                <small>Published:
                    <?= $publication->timestamp; ?> | Status:
                    <?= $publication->publication_status; ?>
                </small>
                <?php if ($publication->profile_id == $_SESSION['profile_id']): ?>
                    <div>
                        <a href="/Publication/modify/<?= $publication->publication_id; ?>"
                            class="btn btn-secondary btn-sm">Edit</a>
                        <a href="/Publication/delete/<?= $publication->publication_id; ?>"
                            class="btn btn-danger btn-sm">Delete</a>

                    </div>
                <?php endif; ?>



                <h2>Comments</h2>
<<<<<<< Updated upstream
                <?php if (!empty($publication->comments)): ?>
            <?php foreach ($publication->comments as $comment): ?>
                <div class="comment mb-2">
                    <p><?= $comment->comment_text; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
      <form action="/Publication/index/<?= $publication_id; ?>" method="post">
    <textarea name="comment" class="form-control mb-2" placeholder="Write a comment..."></textarea>
    <button type="submit" class="btn btn-primary">Post Comment</button>
</form>
    </div>
<?php endforeach; ?>
=======
                <input type="text" name="comment" class="form-control">
                <button>Publish comment</button>
            </div>
        <?php endforeach; ?>
>>>>>>> Stashed changes
    </div>
</body>

</html>