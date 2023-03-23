export function showInfo(ingredientId, ingredintName) {
    // Implementierung der showInfo-Methode
    axios.get(`/getIngredientInfo/${ingredientId}`, {}).then((response) => {
        console.log(response);
        var ingredientInfo = response.data.ingredientInfo;
        // Build the table HTML
        if (ingredientInfo == null) {
            var tableHTML =
                "<p>Zu dieser Zutat gibt es keine Inhaltstoff-Informationen</p>";
        } else {
            var tableHTML =
                `
          <table>
          <tbody>
              <tr>
                  <th><p>Info</p></th>
                  <td>` +
                ingredientInfo.info +
                `</td>
              </tr>
              <tr>
                  <th><p>Energie</p></th>
                  <td>` +
                ingredientInfo.energie +
                `</td>
              </tr>
              <tr>
                  <th>Fett</th>
                  <td>` +
                ingredientInfo.fett +
                `</td>
              </tr>
              <tr>
                  <td>davon Fettsäuren:</th>
                  <td>` +
                ingredientInfo.fattyacids +
                `</td>
              </tr>
              <tr>
                  <th>Kohlenhydrate</th>
                  <td>` +
                ingredientInfo.carbohydrates +
                `</td>
              </tr>
              <tr>
                  <td>davon Fruchtzucker:</td>
                  <td>` +
                ingredientInfo.fruitscarbohydrates +
                `</td>
              </tr>
              <tr>
                  <th><p>Protein</p></th>
                  <td>` +
                ingredientInfo.protein +
                `</td>
              </tr>
              <tr>
                  <th><p>Salz</p></th>
                  <td>` +
                ingredientInfo.salt +
                `</td>
              </tr>
          </tbody>
          </table>
        `;
        }
        // Show the SweetAlert with the table
        Swal.fire({
            title: "Inhaltsstoffe - " + ingredintName,
            html: tableHTML,
            showCloseButton: true,
            showConfirmButton: false,
        });
    });
}
