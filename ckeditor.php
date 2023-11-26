<html>
<head>
<script src="ckeditor.js"></script>
</head>
<body>
<div id="editor"></div>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
</body>
</html>
