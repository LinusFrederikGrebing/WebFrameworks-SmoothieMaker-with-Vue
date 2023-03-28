export  function showInfo(ingredientId, ingredintName) {
    axios.get(`/getIngredientInfo/${ingredientId}`, {}).then((response) => {
        var ingredientInfo = response.data.ingredientInfo;
        // Build the table HTML
        if (ingredientInfo == null) {
            var tableHTML =
                "<p>Zu dieser Zutat gibt es keine Inhaltstoff-Informationen</p>";
        } else {
            var tableHTML =
              `<table class="alert-table">
                 <tbody>
                  <tr>
                    <th class="test"><p>Info</p></th>
                      <td>` + ingredientInfo.info + `</td>
                    </tr>
                    <tr>
                      <th  class="test"><p>Energie</p></th>
                      <td>` + ingredientInfo.energie + `</td>
                    </tr>
                    <tr>
                      <th  class="test">Fett</th>
                      <td>` + ingredientInfo.fett + `</td>
                    </tr>
                    <tr>
                      <td  class="test">davon Fettsäuren:</td>
                      <td>` + ingredientInfo.fattyacids + `</td>
                    </tr>
                    <tr>
                      <th class="test">Kohlenhydrate</th>
                      <td>` + ingredientInfo.carbohydrates + `</td>
                    </tr>
                    <tr>
                      <td  class="test">davon Fruchtzucker:</td>
                      <td>` + ingredientInfo.fruitscarbohydrates + `</td>
                    </tr>
                    <tr>
                      <th  class="test"><p>Protein</p></th>
                      <td>` + ingredientInfo.protein + `</td>
                    </tr>
                    <tr>
                      <th  class="test"><p>Salz</p></th>
                      <td>` + ingredientInfo.salt + `</td>
                    </tr>
                  </tbody>
                </table>`;
        }
        // Show the SweetAlert with the table
        Swal.fire({
            title: "Inhaltsstoffe - " + ingredintName,
            html: tableHTML,
            showCloseButton: true,
            showConfirmButton: false
        })
    });
}

export function showAlertSuccess(title, text) {
  Swal.fire({
    title: title,
    text: text,
    icon: "success",
    showCancelButton: false,
    confirmButtonColor: "#6D9E1F",
    confirmButtonText: "Okay!",
  });
}

export function showAlertError(title, text) {
  Swal.fire({
    title: title,
    text: text,
    icon: "error",
    showCancelButton: false,
    confirmButtonColor: "#6D9E1F",
    confirmButtonText: "Okay!",
  });
}

export function warningAlert() {
  Swal.fire({
    title: "",
    text: "Deine Anmeldung ist fehlgeschlagen. Überprüfe deine Anmeldedaten und probiere es erneut! ",
    icon: "warning",
    confirmButtonColor: "#6D9E1F",
    confirmButtonText: "Wiederholen!",
  });
}