<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorie</title>
</head>
<body>
    <h4><a href="index.php">zpět</a></h4>

    <h1>Správa kategorií</h1>

    <div id="categoriesTree"></div>

    <h2>Nová kategorie (ukázka včetně Ajax)</h2>
    <div>
        <label for="name">Název: </label>
        <input type="text" id="name">
        <div id="nameMessages"></div>
    </div>

    <div>
        <label for="parent">Nadřazená: </label>
        <select id="parent"></select>
        <div id="parentMessages"></div>
    </div>

    <div>
        <input type="button" id="newCategory" value="Odeslat">
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        refreshCategories();

        $("#newCategory").click(function() {
            var name = $("#name").val();
            var parent = $("#parent").val();

            $.ajax({
                url: "categories_controller.php?name=" + name + "&parent=" + parent,
                success: function(data) {
                    $("#nameMessages").empty();
                    $("#parentMessages").empty();

                    if (data.newCategoryOk) {
                        alert("Nová kategorie úspěšně uložena.");
                        $("#name").val("");
                        refreshCategories();
                    }
                    else {
                        alert("Nová kategorie nebyla uložena.");
                        if (data.nameMessages.length > 0) {
                            $("#name").val("");
                            for (var i = 0; i < data.nameMessages.length; i++) {
                                $("#nameMessages").append("<p>" + data.nameMessages[i] + "</p>");
                            }
                        }

                        if (data.idParentMessages.length > 0) {
                            for (var i = 0; i < data.idParentMessages.length; i++) {
                                $("#parentMessages").append("<p>" + data.idParentMessages[i] + "</p>");
                            }
                        }
                    }
                }
            });
        });

        function refreshCategories() {
            $.ajax({
                url: "categories_controller.php?allCategories",
                success: function(categories) {
                    $("#categoriesTree").empty();
                    if (categories.length > 0) {
                        $("#categoriesTree").append("<h2>Výpis kategorií</h2>");
                        showTree(categories);
                    }

                    $("#parent").empty();
                    $("#parent").append('<option value="-1">tato bude hlavní</option>');
                    for (var i = 0; i < categories.length; i++) {
                        $("#parent").append('<option value="' + categories[i].id + '">zařadit pod ' + categories[i].name + '</option>');
                    }
                }
            });
        }

        function showTree(categories) {
            $("#categoriesTree").append('<ul><li id="c-1">kořen (root)</li></ul>');
            for (var i = 0; i < categories.length; i++) {
                $("#c" + categories[i].id_parent).append('<ul><li id="c' + categories[i].id + '">' + categories[i].name + '</li></ul>');
            }
        }
    </script>
</body>
</html>