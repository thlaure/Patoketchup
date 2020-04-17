$(document).ready(function () {
    $("#apply").on("click", function (event) {
        event.preventDefault();

        let ustencils = $.map($("#ustencils > li"), element => {
            return {
                name: $.trim($(element).find(".ustencil").text()).toLowerCase(),
                quantity: $.trim($(element).find(".ustencil-quantity").text()).toLowerCase()
            };
        });

        let ingredients = $.map($("#ingredients > li"), element => {
            return {
                name: $.trim($(element).find(".ingredient").text()).toLowerCase(),
                quantity: $.trim($(element).find(".ingredient-quantity").text()).toLowerCase()
            };
        });

        let tags = $.map($("#tags > span"), element => {
            return { name: $.trim($(element).text().toLowerCase()) };
        });

        let steps = $.map($("#step > li"), element => {
            return { name: $.trim($(element).text()) };
        });

        let formData = new FormData($("#form-recipe")[0]);
        formData.append("image", $("#image")[0].files);
        formData.append("ustencils", JSON.stringify(ustencils));
        formData.append("ingredients", JSON.stringify(ingredients));
        formData.append("tags", JSON.stringify(tags));

        let data = {
            name: $.trim($("#name").val()),
            description: $.trim($("#description").val()),
            time: $.trim($("#time").val()),
            type: $.trim($("#type").val()),
            difficulty: $.trim($("#difficulty").val()),
            nbPersons: $.trim($("#nb-persons").val()),
            advice: $.trim($("#advice").val()),
            ustencils: ustencils,
            ingredients: ingredients,
            tags: tags,
            steps: steps
        };

        if (ustencils.length > 0 && ingredients.length > 0) {
            if ($("#comments").length > 0) {
                $("#comments").html("");
            }
            $("#apply").attr("disabled", false);
            $.ajax({
                url: "publication",
                type: "POST",
                processData: false,
                contentType: false,
                //data: "data=" + JSON.stringify(data), //+ "&form=" + JSON.stringify(formData),
                data: formData,
                success: function () {}
            });
        } else {
            $("#comments").append("<p class='text-danger'><i class='fas fa-exclamation-triangle'></i> Veuillez compléter l'intégralité du formulaire.</p>");
        }
    });
});