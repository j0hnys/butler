
// //vvv does not work in vanilla laravel
// require('fs').readdirSync(__dirname + '/').forEach(function(file) {
//     if (file.match(/\.vue$/) !== null) {
//         var name = file.replace('.vue', '');
//         exports[name] = require('./' + file);
//     }
// });
// //^^^

//pages
exports.index = require("./store/pages/Index.js").default;

exports.project_list_delete = require("./store/pages/project_list_delete.js").default;
exports.project_create = require("./store/pages/project_create.js").default;
exports.project_update = require("./store/pages/project_update.js").default;
exports.definition_list_delete = require("./store/pages/definition_list_delete.js").default;
exports.definition_create = require("./store/pages/definition_create.js").default;
exports.definition_update = require("./store/pages/definition_update.js").default;