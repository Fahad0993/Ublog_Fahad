<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");
bloggerOnly();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="le-edge">

    <!--font awesome-->

    <script src="https://kit.fontawesome.com/d5a99e9161.js" crossorigin="anonymous"></script>

    <!--google fonts-->

    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

    <!--custom css file-->

    <link rel="stylesheet" href="../../assets/css/style.css">

    <!--admin styling-->
    <link rel="stylesheet" href="../../assets/css/admin.css">
    
    <title>Blogger Section - Edit Post</title>
</head>
<body>
    <!--navigation bar: logo(text),nav menu,menu icon-->
    <?php include(ROOT_PATH . "/app/includes/bloggerHeader.php"); ?>

    <!--Admin page wrapper-->
    <div class="admin-wrapper">

        <!--left sidebar-->
        <?php include(ROOT_PATH . "/app/includes/bloggerSidebar.php"); ?>
        <!--//left sidebar-->

        <!--Admin content-->
        <div class="admin-content">
            <div class="button-group">
                <a href="create_posts.php" class="btn btn-big">Add Post</a> 
                <a href="index_posts.php" class="btn btn-big">Manage Post</a>              
            </div>

            <div class="content">
                <h2 class="page-title">Edit Post</h2>
                <?php include(ROOT_PATH . "/app/helpers/formErrors.php");?>
                <form action="edit_posts.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div>
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo $title; ?>" class="text-input">
                    </div>
                    <div>
                        <label>Body</label>
                        <textarea name="body" id="body-element1"><?php echo $body; ?></textarea>
                    </div>
                    <div>
                        <label>Image</label>
                        <input type="file" name="image" class="text-input">
                    </div>
                    <div>
                        <label>Category</label>
                        <select name="topic_id" class="text-input">
                            <option value="">Select a category</option>
                            <?php foreach($topics as $key => $topic): ?>
                                <?php if($topic['cadmin_id'] !== null): ?>
                                <?php if(!empty($topic_id) && $topic_id == $topic['id']):?>
                                    <option selected value="<?php echo $topic['id']; ?>"><?php echo $topic['name']; ?></option>
                                <?php else:?>
                                    <option value="<?php echo $topic['id']; ?>"><?php echo $topic['name']; ?></option>
                                <?php endif;?>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <?php if(empty($published) && $published == 0):?>
                            <label>
                                <input type="checkbox" name="published">
                                Publish
                            </label>
                        <?php else:?>
                            <label>
                                <input type="checkbox" name="published" checked>
                                Publish
                        </label>
                        <?php endif;?>
                    </div>
                    <div>
                        <button type="submit" name="update-post" class="btn btn-big">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
        <!--//Admin content-->
    
    </div>
    <!--//Admin page wrapper-->

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!--cdn for ckeditor-->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>

    <!--custom script-->
    <script src="../../assets/js/scripts.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#body-element1' ), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 
            'numberedList', 'mediaEmbed', 'blockQuote', 'undo', 'redo' ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        } )
        .catch( error => {
            console.log( error );
        } );
    </script>
</body>
</html>