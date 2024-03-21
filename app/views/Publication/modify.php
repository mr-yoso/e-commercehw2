<!DOCTYPE html>
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
    <div class='container'>
        <form method="post"
            action="<?= isset ($publication->publication_id) ? '/Publication/modify/' . $publication->publication_id : '/Publication/modify'; ?>">
            <div class="form-group">
                <label for="publication_title">Title:</label>
                <input type="text" class="form-control" name="publication_title" id="publication_title"
                    placeholder="Enter title here"
                    value="<?= isset ($publication->publication_title) ? $publication->publication_title : ''; ?>">
            </div>
            <div class="form-group">
                <label for="publication_text">Text:</label>
                <input type="text" class="form-control" name="publication_text" id="publication_text"
                    placeholder="Enter text here"
                    value="<?= isset ($publication->publication_text) ? $publication->publication_text : ''; ?>">
            </div>
            <div class="form-group">
                <input type="radio" name="publication_status" id="status_public" value="public"
                    <?= (isset ($publication->publication_status) && $publication->publication_status == 'public') ? 'checked' : ''; ?>>
                <label for="status_public">Public</label>
                <input type="radio" name="publication_status" id="status_private" value="private"
                    <?= (isset ($publication->publication_status) && $publication->publication_status == 'private') ? 'checked' : ''; ?>>
                <label for="status_private">Private</label>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary" />
                <a href="/Publication/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>

</body>

</html>