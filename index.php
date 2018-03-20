<html>
<head>
</head>
<?php
require_once 'app/business/DocBusiness.php';

$docBusiness = new DocBusiness();
$docs = $docBusiness->getDocs();
?>
<body>
<form>
    <select id="docs">
        <option value="0">Selecione uma opcao</option>
        <?php foreach ($docs as $doc) { ?>
            <option value="<?php echo $doc['id'] ?>"><?php echo $doc['tipo'] ?></option>
        <?php } ?>
    </select>
    <div id="elementos">

    </div>
    <div>
        <input id="enviar" type="button" name="enviar" value="Enviar">
    </div>

    <div id="resultado">
    </div>
</form>
</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function () {
        var docs = <?php echo json_encode($docs); ?>;
        var tipoId;

        $("#docs").change(function (e) {
            tipoId = $("#docs").find(':selected').val();

            var doc = docs.filter(function (doc) {
                return doc.id == tipoId;
            }, tipoId)[0];


            var html = "";
            $.each(doc, function (index, campo) {
                if (campo && index != "id" && index != "tipo") {
                    html += "<div>" +
                        "<label>" + campo + "</label>" +
                        "<input class='input' type='text' name='" + campo + "'>" +
                        "</div>";
                }
            });

            $("#elementos").html(html);
        });

        $("#enviar").click(function (e) {
            e.preventDefault();
            var params = "";

            var v = 1;
            $('.input').each(function (index) {
                if ($(this).val().trim() != "") {
                    params += "v" + v.toString() + "=" + $(this).val() + "&";
                }
                v++;
            });

            params += "docs_id=" + tipoId;
            url = "buscar.php?" + params;
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: url,
                success: function (response) {
                    var html_resultado = "";
                    if (response) {
                        $.each(response, function (index, doc) {
                            if (doc.v1) {
                                html_resultado += "<div>" +
                                    "<label>" + doc.c1 + "</label>: <label>" + doc.v1 + "</label>" +
                                    "</div><div/>";
                            }

                            if (doc.v2) {
                                html_resultado += "<div>" +
                                    "<label>" + doc.c2 + "</label>: <label>" + doc.v2 + "</label>" +
                                    "</div><div/>";
                            }

                            if (doc.v3) {
                                html_resultado += "<div>" +
                                    "<label>" + doc.c3 + "</label>: <label>" + doc.v3 + "</label>" +
                                    "</div>";
                            }
                            html_resultado +="<br>"
                        });
                    }
                    $("#resultado").html(html_resultado);
                }
            });
        });
    });
</script>
</html>