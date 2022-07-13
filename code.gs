

function doGet() {
  return HtmlService.createTemplateFromFile('Index').evaluate();
}

//get data from google sheet and return as an array
function getData() {
  var spreadSheetId = "1qPV-qw-8XoAuU_4S3tGwL2qcNhnU7cNrtwPNwWGn454";
  var dataRange = "Form Responses 1!B2:G";

  var range = Sheets.Spreadsheets.Values.get(spreadSheetId, dataRange);
  var values = range.values;

  return values;
}

//include javascript and css files


function include(filename) {
  return HtmlService.createHtmlOutputFromFile(filename)
    .getContent();
}
